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
use \Response;
use \Throwable;

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('mauricerenck/komments', [
    'areas' => require_once(__DIR__ . '/components/areas.php'),
    'options' => require_once(__DIR__ . '/config/options.php'),
    'snippets' => require_once(__DIR__ . '/config/snippets.php'),
    'templates' => [
        'emails/newcomments' => __DIR__ . '/templates/emails/newComments.php'
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
    'fields' => require_once(__DIR__ . '/components/fields.php'),
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
                $shouldReturnJson = ($headers['X-Return-Type'] === 'json');

                $kommentReceiver = new KommentReceiver();
                $kommentModeration = new KommentModeration();

                $targetPage = $kommentReceiver->getPageFromUrl($formData['wmTarget']);
                $spamlevel = 0;
                $isVerified = (!is_null(kirby()->user())) ? kirby()->user()->isLoggedIn() : false;

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

                if (!$kommentReceiver->requiredFieldsAreValid($webmention)) {
                    return $kommentReceiver->sendReponseToClient('mauricerenck.komments.error', 'mauricerenck.komments.invalidfieldvalues', 412, $shouldReturnJson);
                }

                $newEntry = $kommentReceiver->createKomment($webmention, $spamlevel, $isVerified);
                $kommentReceiver->storeData($newEntry, $targetPage);
                $kommentModeration->addCookieToModerationList($newEntry['id']);

                kirby()->trigger('komments.comment.received', []);

                if ($shouldReturnJson) {
                    $response = [
                        'status' => 'success',
                        'pending' => true,
                        'message' => t('mauricerenck.komments.thankyou'),
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
    ]
]);
