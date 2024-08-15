<?php

namespace mauricerenck\Komments;

use mauricerenck\Komments\KommentModeration;
use mauricerenck\Komments\KommentReceiver;
use Kirby\Cms\App as Kirby;
use Kirby\Http\Response;
use Kirby\Toolkit\I18n;

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('mauricerenck/komments', [
    'areas' => require_once(__DIR__ . '/plugin/areas.php'),
    'options' => require_once(__DIR__ . '/plugin/options.php'),
    'snippets' => require_once(__DIR__ . '/plugin/snippets.php'),
    'templates' => [
        'emails/newcomments' => __DIR__ . '/templates/emails/newComments.php'
    ],
    'blueprints' => require_once(__DIR__ . '/plugin/blueprints.php'),
    'pageMethods' => require_once(__DIR__ . '/plugin/page-methods.php'),
    'siteMethods' => require_once(__DIR__ . '/plugin/site-methods.php'),
    'fields' => require_once(__DIR__ . '/plugin/fields.php'),
    'translations' => require_once(__DIR__ . '/plugin/translations.php'),
    'api' => require_once(__DIR__ . '/plugin/api.php'),
    'hooks' => require_once(__DIR__ . '/plugin/hooks.php'),
    'routes' => [
        [
            'pattern' => 'komments/send',
            'method' => 'POST',
            'action' => function () {
                $headers = kirby()->request()->headers();
                $formData = kirby()->request()->data();
                $shouldReturnJson = ($headers['X-Return-Type'] === 'json');

                $kommentReceiver = new KommentReceiver();
                $kommentModeration = new KommentModeration();

                $targetPage = $kommentReceiver->getPageFromUrl($formData['wmTarget']);
                $spamlevel = 0;

                if (is_null($targetPage)) {
                    return $kommentReceiver->sendReponseToClient('mauricerenck.komments.error', 'mauricerenck.komments.pagenotfound', 404, $shouldReturnJson);
                }

                if ($kommentReceiver->isSpam($formData)) {
                    if (option('mauricerenck.komments.auto-delete-spam') === true) {
                        return $kommentReceiver->sendReponseToClient('mauricerenck.komments.error', 'mauricerenck.komments.lookslikespam', 403, $shouldReturnJson);
                    } else {
                        $spamlevel = 100;
                    }
                }

                $webmention = $kommentReceiver->convertToWebmention($formData, $targetPage);
                $isVerified = $kommentReceiver->isVerified($formData['email']);
                $autoPublish = $kommentReceiver->autoPublish($formData['email']);

                if (!$kommentReceiver->requiredFieldsAreValid($webmention)) {
                    return $kommentReceiver->sendReponseToClient('mauricerenck.komments.error', 'mauricerenck.komments.invalidfieldvalues', 412, $shouldReturnJson);
                }

                $newEntry = $kommentReceiver->createKomment($webmention, $spamlevel, $isVerified, $autoPublish);
                $kommentReceiver->storeData($newEntry, $targetPage);

                kirby()->trigger('komments.comment.received', []);

                if ($shouldReturnJson) {
                    $response = [
                        'status' => 'success',
                        'pending' => true,
                        'message' => I18n::translate('mauricerenck.komments.thankyou', null , kirby()->languageCode()),
                        'data' => $webmention
                    ];

                    return new Response(json_encode($response), 'application/json');
                }

                go($targetPage . '#inModeration');
            }
        ],
        [
            'pattern' => 'komments/cron/notification/(:any)',
            'method' => 'GET',
            'action' => function ($secret) {
                if (option('mauricerenck.komments.notifications.cronSecret', '') === $secret) {
                    $notifications = new KommentNotificationUtils();
                    $notifications->sendNotifications();

                    return new Response('sent', 'text/plain');
                }

                return new Response('Forbidden', 'text/plain', 401);
            }
        ],
        [
            'pattern' => '@/comment/(:any)',
            'method' => 'GET',
            'action' => function ($id) {
                $storage = StorageFactory::create();
                $comment = $storage->getSingleComment($id);

                go($comment->pageUuid() . '#c' . $comment->id());
            }
        ],
    ]
]);
