<?php

namespace Plugin\Komments;

use Kirby;
use Kirby\Toolkit\V;
use Kirby\Toolkit\F;
use Kirby\Http\Url;
use Kirby\Http\Server;
use Kirby\Data\Data;
use Kirby\Data\yaml;
use Kirby\Cms\Structure;
use StdClass;
use is_null;
use json_encode;
use \Exception;
use \Response;

@include_once __DIR__ . '/vendor/autoload.php';

load([
    'Plugin\Komments\MastodonSender' => 'utils/sendMastodon.php',
    'Plugin\Komments\WebmentionSender' => 'utils/sendWebmention.php',
    'Plugin\Komments\KommentReceiver' => 'utils/receiveKomment.php',
    'Plugin\Komments\KommentModeration' => 'utils/moderation.php',
    'Plugin\Komments\KommentBaseUtils' => 'utils/base.php',
], __DIR__);

Kirby::plugin('mauricerenck/komments', [
    'options' => require_once(__DIR__ . '/config/options.php'),
    'snippets' => [
        'komments/webmention' => __DIR__ . '/snippets/webmentions.php',
        'komments/webmention-splitted' => __DIR__ . '/snippets/webmentions-splitted.php',
        'komments/kommentform' => __DIR__ . '/snippets/kommentform.php',
        'komments/type/like' => __DIR__ . '/snippets/mention-type-like.php',
        'komments/type/reply' => __DIR__ . '/snippets/mention-type-reply.php',
        'komments/type/repost' => __DIR__ . '/snippets/mention-type-repost.php',
        'komments/type/mention' => __DIR__ . '/snippets/mention-type-mention.php',
    ],
    'blueprints' => [
        'sections/komments' => __DIR__ . '/blueprints/sections/komments.yml'
    ],
    'pageMethods' => [
        'kommentCount' => function () {
            $count = $this->kommentsInbox()->toStructure()->count();
            return $count;
        },
        'hasQueuedKomments' => function ($kommentId, $kommenStatus) {
            $kommentModeration = new KommentModeration();
            return $kommentModeration->pageHasQueuedKomments($kommentId, $kommenStatus);
        },
        'kommentsAreEnabled' => function () {
            $kommentBaseUtils = new KommentBaseUtils();

            if ($kommentBaseUtils->kommentsAreExpired($this)) {
                return false;
            }

            return $this->kommentsEnabledOnpage()->isEmpty() || $this->kommentsEnabledOnpage()->isTrue();
        },
    ],
    'fields' => [
        'kommentType' => [
            'props' => [
            ]
        ],
        'gravatar' => [
            'props' => [
            ]
        ]
    ],
    'translations' => require_once(__DIR__ . '/config/translations.php'),
    'api' => require_once(__DIR__ . '/config/api.php'),
    'hooks' => require_once(__DIR__ . '/config/hooks.php'),
    'routes' => [
        [
            'pattern' => 'komments/send',
            'method' => 'POST',
            'action' => function () {
                $kommentReceiver = new KommentReceiver();
                $kommentModeration = new KommentModeration();
                $targetPage = $kommentReceiver->getPageFromUrl($_POST['wmTarget']);
                $spamlevel = 0;

                if (is_null($targetPage)) {
                    return new Response('<h1>error</h1><p>Your comment couldn\'t be saved</p>', 'text/html');
                }

                if ($kommentReceiver->isSpam($_POST)) {
                    if (option('mauricerenck.komments.auto-delete-spam') === true) {
                        return new Response('<h1>error</h1><p>Your comment was rejected because it looks like spam.</p>', 'text/html');
                    } else {
                        $spamlevel = 100;
                    }
                }

                $webmention = [
                    'type' => 'KOMMENT',
                    'target' => $targetPage->url(),
                    'source' => $targetPage->url(),
                    'published' => $kommentReceiver->setPublishDate(),
                    'content' => $_POST['komment'],
                    'quote' => $_POST['quote'],
                    'author' => [
                        'type' => 'card',
                        'name' => $kommentReceiver->setAuthorName($_POST['author']),
                        'avatar' => $kommentReceiver->setAvatarFromEmail($_POST['email']),
                        'url' => $kommentReceiver->setUrl($_POST['author_url']),
                    ]
                ];

                if (!$kommentReceiver->requiredFieldsAreValid($webmention)) {
                    return new Response('<h1>error</h1><p>Invalid field values</p>', 'text/html');
                }

                $newEntry = $kommentReceiver->createKomment($webmention, $spamlevel);
                $kommentReceiver->storeData($newEntry, $targetPage);
                $kommentModeration->addCookieToModerationList($newEntry['id']);

                go($targetPage . '#inModeration');
            }
        ],
    ]
]);
