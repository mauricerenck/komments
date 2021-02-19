<?php

namespace mauricerenck\Komments;

use mauricerenck\Komments\KommentBaseUtils;
use mauricerenck\Komments\KommentModeration;
use mauricerenck\Komments\KommentReceiver;
use mauricerenck\Komments\MastodonSender;
use mauricerenck\Komments\WebmentionSender;
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

Kirby::plugin('mauricerenck/komments', [
    'options' => require_once(__DIR__ . '/config/options.php'),
    'snippets' => [
        'komments/webmention' => __DIR__ . '/snippets/webmentions-splitted.php',
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
            $count = 0;
            foreach ($this->kommentsInbox()->yaml() as $komment) {
                if ($komment['status'] !== 'false' && $komment['status'] !== false) {
                    $count++;
                }
            }
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
        ],
        'kommentsPending' => []
    ],
    'translations' => require_once(__DIR__ . '/config/translations.php'),
    'api' => require_once(__DIR__ . '/config/api.php'),
    'hooks' => require_once(__DIR__ . '/config/hooks.php'),
    'routes' => [
        [
            'pattern' => 'komments/send',
            'method' => 'POST',
            'action' => function () {
                $headers = kirby()->request()->headers();
                $formData = kirby()->request()->data();

                $kommentReceiver = new KommentReceiver();
                $kommentModeration = new KommentModeration();
                $targetPage = $kommentReceiver->getPageFromUrl($formData['wmTarget']);
                $spamlevel = 0;
                $shouldReturnJson = ($headers['X-Return-Type'] === 'json');

                if (is_null($targetPage)) {
                    if ($shouldReturnJson) {
                        $response = [
                            'status' => 'failed',
                            'message' => t('mauricerenck.komments.pagenotfound'),
                        ];

                        return new Response(json_encode($response), 'application/json', 404);
                    }

                    return new Response('<h1>'.t('mauricerenck.komments.error').'</h1><p>'.t('mauricerenck.komments.pagenotfound').'</p>', 'text/html', 404);
                }

                if ($kommentReceiver->isSpam($formData)) {
                    if (option('mauricerenck.komments.auto-delete-spam') === true) {
                        if ($shouldReturnJson) {
                            $response = [
                                'status' => 'failed',
                                'message' => t('mauricerenck.komments.lookslikespam'),
                            ];

                            return new Response(json_encode($response), 'application/json', 403);
                        }

                        return new Response('<h1>'.t('mauricerenck.komments.error').'</h1><p>'.t('mauricerenck.komments.lookslikespam').'</p>', 'text/html', 403);
                    } else {
                        $spamlevel = 100;
                    }
                }

                $webmention = [
                    'type' => 'KOMMENT',
                    'target' => $targetPage->url(),
                    'source' => $targetPage->url(),
                    'mentionOf' => (!empty($formData['replyTo'])) ? $formData['replyTo'] : null,
                    'published' => $kommentReceiver->setPublishDate(),
                    'content' => $formData['komment'],
                    'quote' => $formData['quote'],
                    'author' => [
                        'type' => 'card',
                        'name' => $kommentReceiver->setAuthorName($formData['author']),
                        'avatar' => $kommentReceiver->setAvatarFromEmail($formData['email']),
                        'url' => $kommentReceiver->setUrl($formData['author_url']),
                    ]
                ];

                if (!$kommentReceiver->requiredFieldsAreValid($webmention)) {
                    if ($shouldReturnJson) {
                        $response = [
                            'status' => 'failed',
                            'message' => t('mauricerenck.komments.invalidfieldvalues'),
                        ];

                        return new Response(json_encode($response), 'application/json', 412);
                    }

                    return new Response('<h1>'.t('mauricerenck.komments.error').'</h1><p>'.t('mauricerenck.komments.invalidfieldvalues').'</p>', 'text/html', 412);
                }

                $isVerified = (!is_null(kirby()->user())) ? kirby()->user()->isLoggedIn() : false;
                $newEntry = $kommentReceiver->createKomment($webmention, $spamlevel, $isVerified);
                $kommentReceiver->storeData($newEntry, $targetPage);
                $kommentModeration->addCookieToModerationList($newEntry['id']);

                if ($shouldReturnJson) {
                    $response = [
                        'status' => 'success',
                        'pending' => true,
                        'message' => t('mauricerenck.komments.thankyou')
                    ];

                    return new Response(json_encode($response), 'application/json');
                }

                go($targetPage . '#inModeration');
            }
        ],
    ]
]);
