<?php

namespace mauricerenck\Komments;

use json_encode;
use json_decode;
use in_array;
use Kirby\Data\yaml;

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

    public function markAsSpam($pageSlug, $kommentId, $isSpam)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $targetPage->kommentsInbox()->yaml();

            for ($i = 0; $i < count($fieldData); $i++) {
                if ($fieldData[$i]['id'] === $kommentId) {
                    if ($isSpam) {
                        $fieldData[$i]['status'] = false;
                        $fieldData[$i]['verified'] = false;
                        $fieldData[$i]['spamlevel'] = 100;
                    } else {
                        $fieldData[$i]['spamlevel'] = 0;
                    }
                }
            }

            $fieldData = yaml::encode($fieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $fieldData
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function markAsVerified($pageSlug, $kommentId, $isVerified)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $targetPage->kommentsInbox()->yaml();

            for ($i = 0; $i < count($fieldData); $i++) {
                if ($fieldData[$i]['id'] === $kommentId) {
                    $fieldData[$i]['verified'] = $isVerified;
                }
            }

            $fieldData = yaml::encode($fieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $fieldData
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function publish($pageSlug, $kommentId, $publish)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $targetPage->kommentsInbox()->yaml();

            for ($i = 0; $i < count($fieldData); $i++) {
                if ($fieldData[$i]['id'] === $kommentId) {
                    $fieldData[$i]['status'] = $publish;
                }
            }

            $fieldData = yaml::encode($fieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $fieldData
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($pageSlug, $kommentId)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $targetPage->kommentsInbox()->yaml();
            $newFieldData = [];

            for ($i = 0; $i < count($fieldData); $i++) {
                if ($fieldData[$i]['id'] !== $kommentId) {
                    $newFieldData[] = $fieldData[$i];
                }
            }

            $newFieldData = yaml::encode($newFieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $newFieldData
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function removeUidFromCookie($kommentsAwaitingModeration, $uid)
    {
        $cleanedUids = array_diff($kommentsAwaitingModeration, [$uid]);
        setcookie($this->cookie_name, json_encode($cleanedUids), time() + (86400 * 256), '/');
    }
}
