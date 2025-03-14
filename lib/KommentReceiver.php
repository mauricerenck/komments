<?php

namespace mauricerenck\Komments;

use Kirby\Toolkit\V;
use Kirby\Toolkit\Str;
use Kirby\Http\Remote;

class KommentReceiver
{

    public function __construct(private ?array $autoPublish = null, private ?bool $autoPublishVerified = null, private ?bool $akismet = null, private ?string $akismetApiKey = null, private ?bool $debug = null)
    {
        $this->autoPublish = $autoPublish ?? option('mauricerenck.komments.moderation.autoPublish', []);
        $this->autoPublishVerified = $autoPublishVerified ?? option('mauricerenck.komments.moderation.publish-verified', false);
        $this->akismet = $akismet ?? option('mauricerenck.komments.spam.akismet', false);
        $this->akismetApiKey = $akismetApiKey ?? option('mauricerenck.komments.spam.akismet_api_key', '');
        $this->debug = $debug ?? option('mauricerenck.komments.debug', false);
    }

    public function validateFields(array $fields): array
    {
        $inValidFields = [];

        if (V::notEmpty($fields['author_url']) && !V::url($fields['author_url'])) {
            $inValidFields[] = 'author_url';
        }

        if (!V::email($fields['email'])) {
            $inValidFields[] = 'email';
        }

        if (V::empty($fields['author'])) {
            $inValidFields[] = 'author';
        }

        if (V::empty($fields['comment']) || !V::minWords($fields['comment'], 1)) {
            $inValidFields[] = 'comment';
        }

        return $inValidFields;
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

        $spamlevel += $this->akismetCheck($fields, $page);;

        return $spamlevel > 100 ? 100 : $spamlevel;
    }

    public function isVerified(): bool
    {
        return (!is_null(kirby()->user()) && kirby()->user()->isLoggedIn()) ? true : false;
    }

    public function autoPublish(string $email, bool $isVerified): bool
    {
        if ($this->autoPublishVerified && $isVerified) {
            return true;
        }

        return in_array($email, $this->autoPublish);
    }

    public function getParentId(string $replyTo): string
    {
        return V::notEmpty($replyTo) ? $replyTo : '';
    }

    public function getAvatarFromEmail(string $email): ?string
    {
        if (V::email($email)) {
            $mailHash = md5($email);
            return 'https://www.gravatar.com/avatar/' . $mailHash;
        }

        return null;
    }

    public function getEmail(string $email): ?string
    {
        if (!option('mauricerenck.komments.privacy.storeEmail', false)) {
            return null;
        }

        if (V::email($email)) {
            $mailHash = md5($email);
            return 'https://www.gravatar.com/avatar/' . $mailHash;
        }

        return null;
    }

    public function createSafeString(string $fieldValue): string
    {
        return Str::unhtml($fieldValue);
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
