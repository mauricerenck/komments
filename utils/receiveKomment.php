<?php

namespace mauricerenck\Komments;

use Kirby\Toolkit\V;
use Kirby\Toolkit\Str;
use Kirby\Data\yaml;
use Kirby\Http\Response;

class KommentReceiver
{
    public function storeData(array $newEntry, $targetPage)
    {

        if(is_string($targetPage)) {
            $targetPage = page($targetPage);
        }

        $fieldData = $targetPage->kommentsInbox()->yaml();
        $fieldData[] = $newEntry;
        $fieldData = yaml::encode($fieldData);

        $kirby = kirby();
        $kirby->impersonate('kirby');
        $targetPage->update([
            'kommentsInbox' => $fieldData
        ]);
    }

    public function convertToWebmention($formData, $targetPage)
    {
        return [
            'type' => 'KOMMENT',
            'target' => $targetPage->url(),
            'source' => $targetPage->url(),
            'mentionOf' => (!empty($formData['replyTo'])) ? $formData['replyTo'] : null,
            'published' => $this->setPublishDate(),
            'content' => $formData['komment'],
            'quote' => $formData['quote'],
            'author' => [
                'type' => 'card',
                'name' => $this->setAuthorName($formData['author']),
                'avatar' => $this->setAvatarFromEmail($formData['email']),
                'url' => $this->setUrl($formData['author_url']),
                'email' => $this->setEmail($formData['email']),
            ]
        ];
    }

    public function createKomment($webmention, $spamlevel = 0, $isVerified = false, $autoPublish = false)
    {
        $publishComments = $isVerified || $autoPublish;
        $author = $this->getAuthorData($webmention['author']);

        return [
            'id' => md5($webmention['target'] . $author['name'] . $webmention['published']),
            'avatar' => $this->setUrl($author['avatar']),
            'author' => $author['name'],
            'authorUrl' => $this->setUrl($author['url']),
            'authorEmail' => $this->setEmail($author['email']),
            'source' => $this->setUrl($webmention['source']),
            'target' => $this->setUrl($webmention['target']),
            'mentionOf' => (!isset($webmention['mentionOf']) || is_null($webmention['mentionOf'])) ? $this->setUrl($webmention['target']) : $webmention['mentionOf'],
            'property' => $webmention['type'],
            'published' => $webmention['published'],
            'komment' => $this->setKomment($webmention['content']),
            'quote' => (isset($webmention['quote'])) ? $this->setKomment($webmention['quote']) : null,
            'kommentType' => $this->convertWebmentionTypes($webmention['type']),
            'status' => $this->setStatus($webmention['type'], $publishComments),
            'spamlevel' => $spamlevel,
            'verified' => $isVerified
        ];
    }

    public function convertWebmentionTypes($type) {

        $oldTypes = ['LIKE', 'REPOST', 'BOOKMARK', 'REPLY', 'RSVP', 'MENTION', 'INVITE', 'KOMMENT'];

        if(in_array($type, $oldTypes)) { return $type; }

        switch($type) {
            case 'like-of':
                return 'LIKE';
            case 'repost-of':
                return 'REPOST';
            case 'bookmark-of':
                return 'BOOKMARK';
            case 'in-reply-to':
                return 'REPLY';
            case 'rsvp':
                return 'RSVP';
            case 'mention-of':
                return 'MENTION';
            case 'invite':
                return 'INVITE';
            default:
                return 'KOMMENT';
        }
    }

    public function getAuthorData(array $author) {
        return [
            'name' => $author['name'] ?? null,
            'avatar' => $author['avatar'] ?? null,
            'url' => $author['url'] ?? null,
            'email' => $author['email'] ?? null,
        ];
    }

    public function getPageFromUrl(string $url)
    {
        if (V::url($url)) {
            // use kirby->url because it includes the path of a possible subfolder install
            $kirbyBaseUrl = kirby()->url();
            $path = substr($url, strlen($kirbyBaseUrl));

            if ($path == '') {
                $targetPage = page(site()->homePageId());
            } elseif (!$targetPage = page($path)) {
                $targetPage = page(kirby()->router()->call($path));

                if ($targetPage->isErrorPage()) {
                    return null;
                }
            }

            if (is_null($targetPage)) {
                return null;
            }

            return $targetPage;
        }

        return null;
    }

    public function requiredFieldsAreValid($komment)
    {
        return (!is_null($komment['author']['avatar']) && !is_null($komment['author']['name']) && !is_null($komment['content']));
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

    public function isVerified($email)
    {
        if (!is_null(kirby()->user()) && kirby()->user()->isLoggedIn()) {
            return true;
        }

        if (!V::email($email)) {
            return false;
        }

        return false;
    }

    public function autoPublish($email) {
        return (in_array($email, option('mauricerenck.komments.moderation.autoPublish', [])));
    }

    public function setUrl($url)
    {
        if (V::url($url)) {
            return $url;
        }

        return null;
    }

    public function setKomment($komment)
    {
        if (V::url($komment)) {
            return null;
        }

        return Str::unhtml($komment);
    }

    public function setStatus($type, $isVerified)
    {
        if ($type === 'KOMMENT' && option('mauricerenck.komments.komment-auto-publish', false)) {
            return true;
        }

        if ($type === 'KOMMENT' && $isVerified && option('mauricerenck.komments.auto-publish-verified', true)) {
            return true;
        }

        if ($type !== 'KOMMENT' && option('mauricerenck.komments.webmention-auto-publish', false)) {
            return true;
        }

        return false;
    }

    public function setPublishDate()
    {
        return date('c');
    }

    public function setAuthorName($name)
    {
        if (is_string($name)) {
            return $name;
        }

        return null;
    }

    public function setAvatarFromEmail(string $email)
    {
        if (V::email($email)) {
            $mailHash = md5($email);
            return 'https://www.gravatar.com/avatar/' . $mailHash;
        }

        return null;
    }

    public function setEmail(string | null $email) {

        if(is_null($email)) {
            return null;
        }

        if(option('mauricerenck.komments.privacy.storeEmail', false)) {
            if (V::email($email)) {
                return $email;
            }
        }

        return null;
    }

    public function sendReponseToClient(string $headlineTranslationString, string $messageTranslationString, int $httpCode, bool $shouldReturnJson)
    {
        if ($shouldReturnJson) {
            $response = [
                'status' => $headlineTranslationString,
                'message' => t($messageTranslationString),
            ];

            return new Response(json_encode($response), 'application/json', $httpCode);
        }

        return new Response('<h1>' . t($headlineTranslationString) . '</h1><p>' . t($messageTranslationString) . '</p>', 'text/html', $httpCode);
    }
}
