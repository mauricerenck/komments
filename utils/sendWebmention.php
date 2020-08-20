<?php

namespace Plugin\Komments;

use Kirby\Toolkit\V;
use Kirby\Data\Data;
use \IndieWeb\MentionClient;
use file_exists;
use implode;
use in_array;

class WebmentionSender
{
    private $page;
    private $outbox;
    private $outboxPath;
    private $processed;
    private $mentionClient;
    private $fieldsToParseUrls;

    public function __construct($page)
    {
        $this->page = $page;
        $this->outboxPath = $this->page->root() . '/outbox.json';
        $this->outbox = $this->getOutbox();
        $this->mentionClient = new MentionClient();
        $this->processed = [];
        $this->fieldsToParseUrls = option('mauricerenck.komments.send-mention-url-fields');
    }

    public function send()
    {
        if ($this->page->status() != 'listed') {
            return;
        }

        if (option('mauricerenck.komments.ping-archiveorg')) {
            if ($this->shouldPingUrl('https://web.archive.org/save/' . $this->page->url())) {
                $this->informArchiveOrg($this->page->url());
                $this->addToProcessed('https://web.archive.org/save/' . $this->page->url());
            }
        }

        $urls = $this->parseUrls();

        foreach ($urls as $targetUrl) {
            if ($this->shouldPingUrl($targetUrl)) {
                $webmention = $this->sendMention($targetUrl);
            }

            $this->addToProcessed($targetUrl);
        }

        $this->writeOutbox();
    }

    public function templateIsWhitelisted($template)
    {
        $whitelist = option('mauricerenck.komments.send-limit-to-templates', []);
        return (in_array($template, $whitelist) || count($whitelist) === 0);
    }

    private function informArchiveOrg($targetUrl)
    {
        $options = [
            CURLOPT_URL => ('https://web.archive.org/save/' . $targetUrl),
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
            CURLOPT_USERAGENT => 'Kirby'
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
    }

    // credits to: https://github.com/sebastiangreger/kirby3-sendmentions/blob/master/src/SendMentions.php
    private function sendMention($targetUrl)
    {
        $endpoint = $this->mentionClient->discoverWebmentionEndpoint($targetUrl);

        if ($endpoint) {
            // not sending webmentions to localhost (W3C spec 4.3)
            if (strpos($endpoint, '//localhost') === true || strpos($endpoint, '//127.0.0') === true) {
                return 'failed';
            }

            // send webmention
            $response = $this->mentionClient->sendWebmention($this->page->url(), $targetUrl);

            return 'webmention';
        } elseif ($response = $this->mentionClient->sendPingback($this->page->url(), $targetUrl)) {
            return 'pingback';
        }
        return 'failed';
    }

    private function getOutbox()
    {
        if (!file_exists($this->outboxPath)) {
            return [];
        }

        try {
            $outbox = Data::read($this->outboxPath);
        } catch (Exception $e) {
            return [];
        }

        return $outbox;
    }

    private function writeOutbox()
    {
        Data::write($this->outboxPath, $this->processed);
    }

    private function addToProcessed($targetUrl)
    {
        $this->processed[] = $targetUrl;
    }

    // credits to: https://github.com/sebastiangreger/kirby3-sendmentions/blob/master/src/SendMentions.php
    private function parseUrls()
    {
        $contentFields = [];
        foreach ($this->fieldsToParseUrls as $fieldName) {
            $contentFields[] = $this->page->content()->$fieldName()->html();
        }

        $parseText = implode(' ', $contentFields);

        $regexUrlPattern = "#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#iS";
        if (preg_match_all($regexUrlPattern, (string) $parseText, $allUrlsInContent)) {
            return $allUrlsInContent[0];
        } else {
            return [];
        }
    }

    private function shouldPingUrl($targetUrl)
    {
        if (!V::url($targetUrl)) {
            return false;
        }

        if (in_array($targetUrl, $this->processed)) {
            return false;
        }

        foreach ($this->outbox as $outboxUrl) {
            if ($outboxUrl === $targetUrl) {
                return false;
            }
        }

        return true;
    }
}
