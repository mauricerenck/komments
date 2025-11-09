<?php

namespace mauricerenck\Komments;

use Kirby\Toolkit\V;
use Kirby\Toolkit\Str;
use Kirby\Http\Remote;

class KommentReceiver
{

    public function __construct(
        private ?array $autoPublish = null,
        private ?bool $autoPublishVerified = null,
        private ?bool $akismet = null,
        private ?string $akismetApiKey = null,
        private ?bool $debug = null,
        private ?array $spamKeywords = null,
        private ?array $spamPhrases = null,
        private ?bool $verificationEnabled = null,
        private ?bool $verificationTtl = null,
        private ?bool $verificationSecret = null
    ) {
        $this->autoPublish = $autoPublish ?? option('mauricerenck.komments.moderation.autoPublish', []);
        $this->autoPublishVerified = $autoPublishVerified ?? option('mauricerenck.komments.moderation.publish-verified', false);
        $this->akismet = $akismet ?? option('mauricerenck.komments.spam.akismet', false);
        $this->akismetApiKey = $akismetApiKey ?? option('mauricerenck.komments.spam.akismet_api_key', '');
        $this->spamKeywords = $spamKeywords ?? option('mauricerenck.komments.spam.keywords', []);
        $this->spamPhrases = $spamPhrases ?? option('mauricerenck.komments.spam.phrases', []);
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

        // detect sanitation
        $comment = $this->sanitize_string($fields['comment']);
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

    public function sanitize_string($comment)
    {
        // Remove non-printable characters
        $comment = preg_replace('/[^\P{C}\n]+/u', '', $comment);
        // Convert special characters to HTML entities
        $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
        // Trim whitespace
        $comment = trim($comment);
        return $comment;
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
            return $email;
        }

        return null;
    }

    public function createSafeString(string $fieldValue): string
    {
        return $this->sanitize_string(Str::unhtml($fieldValue));
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

    public function sendVerificationMail(string $email, string $username, string $commentId): void
    {

        $verification = new CommentVerification();
        if (!$verification->isVerificationEnabled()) {
            return;
        }

        $verificationUrl = $verification->getVerificationUrl(email: $email, commentId: $commentId);

        if (!$verificationUrl) {
            return;
        }

        kirby()->email([
            'from' => option('mauricerenck.komments.notifications.email.sender'),
            'to' => $email,
            'subject' => 'Verify your Comment',
            'template' => 'mailverification',
            'data' => [
                'username' => $username,
                'commentId' => $commentId,
                'expireHours' => option('mauricerenck.komments.spam.verification.ttl', 48),
                'verificationUrl' => $verificationUrl,
            ],
        ]);
    }
}
