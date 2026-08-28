<?php

namespace mauricerenck\Komments;

use Kirby\Toolkit\V;
use Kirby\Http\Remote;

class SpamHandler
{

    public function __construct(
        private ?bool $debug = null,

        private ?bool $akismet = null,
        private ?string $akismetApiKey = null,
        private ?array $spamKeywords = null,
        private ?array $spamPhrases = null,
        private ?KommentUtils $utils = null,
    ) {
        $this->debug = $debug ?? option('mauricerenck.komments.debug', false);

        $this->akismet = $akismet ?? option('mauricerenck.komments.spam.akismet', false);
        $this->akismetApiKey = $akismetApiKey ?? option('mauricerenck.komments.spam.akismet_api_key', '');
        $this->spamKeywords = $spamKeywords ?? option('mauricerenck.komments.spam.keywords', []);
        $this->spamPhrases = $spamPhrases ?? option('mauricerenck.komments.spam.phrases', []);

        $this->utils = $utils ?? new KommentUtils();
    }

    public function getSpamlevel(array $fields, $page): int
    {
        $spamlevel = 0;
        if (V::notEmpty($fields['url'])) {
            $spamlevel += 80;
        }

        if (V::url($fields['url'])) {
            $spamlevel = 100;
        }

        $url_pattern = '/https?:\/\/[^\s]+/';
        preg_match_all($url_pattern, $fields['comment'], $matches);

        if (count($matches[0]) > 0) {
            $spamlevel += 10 + count($matches[0]) * 2;
        }

        // detect html tags
        $html_pattern = '/<[^>]*>/';
        preg_match_all($html_pattern, $fields['comment'], $matches);

        if (count($matches[0]) > 0) {
            $spamlevel += 60;
        }

        // detect sanitation
        $comment = $this->utils->sanitizeString($fields['comment']);
        if ($comment !== $fields['comment']) {
            $spamlevel += 20;
        }

        // detect spam keywords
        foreach ($this->spamKeywords as $keyword) {
            if (stripos($fields['comment'], $keyword) !== false) {
                $spamlevel += 10;
            }
        }

        // detect spam phrases
        foreach ($this->spamPhrases as $phrase) {
            if (stripos($fields['comment'], $phrase) !== false) {
                $spamlevel += 15;
            }
        }

        $spamlevel += $this->akismetCheck($fields, $page);

        return $spamlevel > 100 ? 100 : $spamlevel;
    }

    public function akismetCheck(array $fields, $page): int
    {
        if (!$this->akismet) {
            return 0;
        }

        try {
            $data = [
                'api_key' => urlencode($this->akismetApiKey),
                'blog' => urlencode(site()->url()),
                'user_ip' => urlencode($_SERVER['REMOTE_ADDR']),
                'user_agent' => urlencode($_SERVER['HTTP_USER_AGENT']),
                'referrer' => urlencode($_SERVER['HTTP_REFERER']),
                'permalink' => urlencode($page->permalink()),
                'comment_type' => urlencode('comment'),
                'comment_author' => urlencode($fields['author']),
                'comment_author_email' => urlencode($fields['author_email'] ?? ''),
                'comment_author_url' => urlencode($fields['author_url']),
                'comment_content' => urlencode($fields['comment']),
                'honeypot_field_name' => urlencode('url'),
            ];

            if ($this->debug) {
                $data['is_test'] = true;
            }

            $response = Remote::request('https://rest.akismet.com/1.1/comment-check', [
                'method' => 'POST',
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'data' => $data,
            ]);

            if ($response->code() !== 200) {
                return 0;
            }

            return $response->content() == 'true' ? 100 : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
