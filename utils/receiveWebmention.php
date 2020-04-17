<?php

namespace Plugin\Komments;

use Kirby\Http\Url;
use Kirby\Toolkit\V;
use Kirby\Toolkit\Str;
use json_decode;
use json_encode;
use is_null;
use preg_split;
use str_replace;
use date;

class WebmentionReceiver
{
    public function createKommentObject()
    {
        $komment = [
            'post' => [
                'author' => [
                    'photo' => null,
                    'name' => null,
                    'url' => null
                ],
                'content' => [
                    'text' => null,
                    'quote' => null
                ]
            ]
        ];

        return json_decode(json_encode($komment, JSON_FORCE_OBJECT));
    }

    public function getPageFromUrl(string $url)
    {
        if (V::url($url)) {
            $path = Url::path($url);
            $languages = kirby()->languages();

            if ($languages->count() > 0) {
                foreach ($languages as $language) {
                    $path = str_replace($language . '/', '', $path);
                }
            }

            $targetPage = page($path);

            if (is_null($targetPage)) {
                return null;
            }

            return $targetPage;
        }

        return null;
    }

    public function getMentionTitle($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        preg_match("/\<title.*\>(.*)\<\/title\>/isU", $html, $matches);
        return $matches[1];
    }

    public function requiredFieldsAreValid($komment)
    {
        return (!is_null($komment['avatar']) && !is_null($komment['author']) && !is_null($komment['komment']));
    }

    public function isSpam($rawKommentData)
    {
        if (!empty(trim($rawKommentData['url']))) {
            return true;
        }

        if (empty($rawKommentData['cts']) || $rawKommentData['cts'] < 10) {
            return true;
        }

        return false;
    }

    public function setAvatarFromEmail(string $email)
    {
        if (V::email($email)) {
            $mailHash = md5($email);
            return 'https://www.gravatar.com/avatar/' . $mailHash;
        }

        return null;
    }

    public function setUrl($url)
    {
        if (V::url($url)) {
            return $url;
        }

        return null;
    }

    public function setAuthorName($name)
    {
        if (V::alphanum($name)) {
            return $name;
        }

        return null;
    }

    public function setPublishDate()
    {
        return date('c');
    }

    public function setKomment($komment)
    {
        if (Str::isURL($komment)) {
            return null;
        }

        return Str::unhtml($komment);
    }
}
