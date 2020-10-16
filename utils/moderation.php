<?php

namespace mauricerenck\Komments;

use json_encode;
use json_decode;
use in_array;

class KommentModeration
{
    private $cookie_name;

    public function __construct()
    {
        $this->cookie_name = 'komments-in-moderation';
    }

    public function addCookieToModerationList($uid)
    {
        $cookie_value = [];

        if (isset($_COOKIE[$this->cookie_name])) {
            $cookie_value = json_decode($_COOKIE[$this->cookie_name]);
        }

        $cookie_value[] = $uid;

        setcookie($this->cookie_name, json_encode($cookie_value), [
            'expires' => time() + (86400 * 256),
            'path' => '/',
            'secure' => true,
            'samesite' => 'None'
        ]);
    }

    public function getModerationListFromCookie()
    {
        if (isset($_COOKIE[$this->cookie_name])) {
            return json_decode($_COOKIE[$this->cookie_name]);
        }

        return false;
    }

    public function pageHasQueuedKomments($uid, $kommenStatus)
    {
        $kommentsAwaitingModeration = $this->getModerationListFromCookie();

        if (!$kommentsAwaitingModeration) {
            return false;
        }

        if (in_array($uid, $kommentsAwaitingModeration)) {
            if ($kommenStatus->isTrue()) {
                $this->removeUidFromCookie($kommentsAwaitingModeration, $uid);
                return false;
            }

            return true;
        }

        return false;
    }

    private function removeUidFromCookie($kommentsAwaitingModeration, $uid)
    {
        $cleanedUids = array_diff($kommentsAwaitingModeration, [$uid]);
        setcookie($this->cookie_name, json_encode($cleanedUids), time() + (86400 * 256), '/');
    }
}
