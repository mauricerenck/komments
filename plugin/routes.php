<?php

namespace mauricerenck\Komments;

use Kirby\Http\Response;
use Kirby\Toolkit\I18n;
use Kirby\Uuid\Uuid;

return [
    [
        'pattern' => 'komments/send',
        'method' => 'POST',
        'action' => function () {
            $headers = kirby()->request()->headers();
            $formData = kirby()->request()->data();
            $shouldReturnJson = ($headers['X-Return-Type'] === 'json');

            $page = page($formData['pageUuid']);

            if (is_null($page)) {
                return new Response('Page Not Found', 'application/json', 404);
            }

            $receiver = new KommentReceiver();

            $invalidFields = $receiver->validateFields($formData);
            if (count($invalidFields) > 0) {
                $errorMessage = [
                    'status' => 'error',
                    'message' => I18n::translate('mauricerenck.komments.invalidfieldvalues', null , $formData['language']),
                    'fields' => $invalidFields
                ];

                return new Response(json_encode($errorMessage), 'application/json', 406);
            }

            $spamlevel = $receiver->getSpamlevel($formData);
            if ($spamlevel > option('mauricerenck.komments.spam.sensibility', 60)) {
                $errorMessage = [
                    'status' => 'error',
                    'message' => I18n::translate('mauricerenck.komments.lookslikespam', null , $formData['language'])
                ];

                if (option('mauricerenck.komments.spam.delete', true) === true) {
                    return new Response(json_encode($errorMessage), 'application/json', 403);
                }
            }

            $storage = StorageFactory::create();

            $id = Uuid::generate();
            $date = date('c', time());

            $verified = $receiver->isVerified($formData['email']);
            $autoPublish = $receiver->autoPublish($formData['email'], $verified);

            $comment = $storage->createComment(
                id: $id,
                pageUuid: $receiver->createSafeString($formData['pageUuid']),
                parentId: $receiver->getParentId($formData['replyTo']),
                type: 'comment',
                content: $receiver->createSafeString($formData['comment']),
                authorName: $receiver->createSafeString($formData['author']),
                authorAvatar: $receiver->getAvatarFromEmail($formData['email']),
                authorEmail: $receiver->getEmail($formData['email']),
                authorUrl: $receiver->createSafeString($formData['author_url']),
                published: $autoPublish,
                verified: $verified,
                spamlevel: $spamlevel,
                language: $receiver->createSafeString($formData['language']),
                upvotes: 0,
                downvotes: 0,
                createdAt: $date,
                updatedAt: $date,
            );

            $storage->saveComment($comment);

            kirby()->trigger('komments.comment.received', []);

            if ($shouldReturnJson) {
                $response = [
                    'status' => 'success',
                    'message' => I18n::translate('mauricerenck.komments.thankyou', null , $formData['language']),
                ];

                return new Response(json_encode($response), 'application/json', 200);
            }

            go($page->url());
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
];