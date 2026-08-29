<?php

namespace mauricerenck\Komments;

use Kirby\Http\Response;
use Kirby\Toolkit\I18n;
use Kirby\Uuid\Uuid;
use Kirby\Cms\Page;

return [
    [
        'pattern' => 'komments/send',
        'method' => 'POST',
        'action' => function () {
            $headers = kirby()->request()->headers();
            $formData = kirby()->request()->data();
            $shouldReturnJson = (array_key_exists('X-Return-Type', $headers) && $headers['X-Return-Type'] === 'json');

            $page = page($formData['pageUuid']);

            if (is_null($page)) {
                return new Response('Page Not Found', 'application/json', 404);
            }

            $receiver = new KommentReceiver();

            // VALIDATE FIELDS
            $invalidFields = $receiver->validateFields($formData);
            if (count($invalidFields) > 0) {
                $errorMessage = [
                    'status' => 'error',
                    'message' => I18n::translate('mauricerenck.komments.invalidfieldvalues', null, $formData['language']),
                    'fields' => $invalidFields
                ];

                return new Response(json_encode($errorMessage), 'application/json', 406);
            }

            // CHECK FOR SPAM
            $spamHandler = new SpamHandler();
            $spamLevel = $spamHandler->getSpamlevel($formData, $formData['pageUuid']);
            if ($spamLevel > option('mauricerenck.komments.spam.sensibility', 60)) {
                $errorMessage = [
                    'status' => 'error',
                    'message' => I18n::translate('mauricerenck.komments.lookslikespam', null, $formData['language'])
                ];

                if (option('mauricerenck.komments.spam.delete', true) === true) {
                    return new Response(json_encode($errorMessage), 'application/json', 403);
                }
            }

            $commentData = $receiver->transformFormData($formData, $spamLevel);

            $storage = StorageFactory::create();
            $storage->saveComment($commentData);

            // COMMENT EMAIL VERIFICATION
            if (option('mauricerenck.komments.spam.verification.enabled', false)) {
                $email = $commentData->email();

                if (!is_null($email)) {
                    $receiver->sendVerificationMail(
                        email: $email->value(),
                        username: $commentData->author()->value(),
                        commentId: $commentData->id()->value()
                    );
                }
            }

            // TRIGGER HOOKS
            kirby()->trigger('komments.comment.received', ['comment' => $commentData]);

            if ($commentData->parentId()->isNotEmpty()) {
                kirby()->trigger('komments.comment.replied', ['comment' => $commentData]);
            }

            // RETURN json in case of javascript enabled form
            if ($shouldReturnJson) {
                $translationCode = option('mauricerenck.komments.spam.verification.enabled', false)
                    ? 'mauricerenck.komments.verify'
                    : 'mauricerenck.komments.thankyou';

                $response = [
                    'status' => 'success',
                    'message' => I18n::translate($translationCode, null, $commentData->language()->value()),
                ];

                return new Response(json_encode($response), 'application/json', 200);
            }

            // go back to page on regular form submit
            go($page->url());
        }
    ],
    [
        'pattern' => 'komments/verify-comment/(:any)',
        'method' => 'GET',
        'action' => function ($token) {
            $verification = new CommentVerification();

            if (!$verification->isVerificationEnabled()) {
                return new Response('Not found!', 'text/plain', 404);
            }

            $result = $verification->verifyToken(token: $token);

            if ($result === false) {
                return new Response('Forbidden', 'text/plain', 401);
            }

            $home = page('home');
            $data = [
                'slug' => 'comment-verified',
                'parent' => $home,
                'template' => 'comment-verified',
                'content' => [
                    'title' => option('mauricerenck.komments.spam.verification.title', 'Thank you'),
                    'commentId' => $result,
                    'uuid' => Uuid::generate(),
                ],
            ];

            $page = Page::factory($data);

            site()->visit($page);

            return $page;
        }
    ],
    [
        'pattern' => 'komments/cron/notification/(:any)',
        'method' => 'GET',
        'action' => function ($secret) {
            if (option('mauricerenck.komments.notifications.cronSecret', '') === $secret && $secret !== '') {
                $notifications = new KommentNotifications();
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

            if (!$comment) {
                return new Response('Not Found', 'text/plain', 404);
            }

            $page = page($comment->pageUuid());

            if (!$page) {
                return new Response('Not Found', 'text/plain', 404);
            }

            if (option('mauricerenck.komments.webmentions.sendReplies', false)) {
                return new Page([
                    'slug' => '@/comment/' . $id,
                    'template' => 'komment-response',
                    'content' => [
                        'title' => $page->title(),
                        'text'  => $comment->content(),
                        'inReplyTo' => $comment->parentId(),
                        'authorUrl' => $comment->authorUrl(),
                        'authorName' => $comment->authorName(),
                        'authorAvatar' => $comment->authorAvatar(),
                        'commentLink' => '/@/comment/' . $id
                    ]
                ]);
            }

            go($comment->pageUuid() . '#c' . $comment->id());
        }
    ]
];
