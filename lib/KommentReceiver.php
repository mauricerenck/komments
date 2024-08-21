<?php

namespace mauricerenck\Komments;

use Kirby\Toolkit\V;
use Kirby\Toolkit\Str;

class KommentReceiver {
    public function validateFields(array $fields) {
        $inValidFields = [];

        if(V::notEmpty($fields['author_url']) && !V::url($fields['author_url'])) {
            $inValidFields[] = 'author_url';
        }

        if(!V::email($fields['email'])) {
            $inValidFields[] = 'email';
        }

        if (V::empty($fields['author'])) {
            $inValidFields[] = 'author';
        }

        if (V::empty($fields['comment']) || !V::minWords($fields['comment'], 1)) {
            $inValidFields[] = 'v';
        }

        return $inValidFields;
    }

    public function getSpamlevel(array $fields): int
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

        if(count($matches[0]) > 0) {
            $spamlevel += 10 + count($matches[0]) * 2;
        }

        // detect html tags
        $html_pattern = '/<[^>]*>/';
        preg_match_all($html_pattern, $fields['comment'], $matches);

        if(count($matches[0]) > 0) {
            $spamlevel += 60;
        }

        // TODO akismet check

        return $spamlevel > 100 ? 100 : $spamlevel;
    }

    public function isVerified(string $email): bool
    {
        return (!is_null(kirby()->user()) && kirby()->user()->isLoggedIn()) ? true : false;
    }

    public function autoPublish(string $email, bool $isVerified): bool
    {
        if(option('mauricerenck.komments.moderation.publish-verified', false) && $isVerified) {
            return true;
        }

        return in_array($email, option('mauricerenck.komments.moderation.autoPublish', []));
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
        if(!option('mauricerenck.komments.privacy.storeEmail', false)) {
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
}
