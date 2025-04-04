<?php

namespace mauricerenck\Komments;

use Kirby\Http\Response;

return [
    'routes' => [
        [
            'pattern' => 'komments/flag/(:any)/(:any)',
            'method' => 'POST',
            'action' => function (string $id, string $flag) {
                $kommentModeration = new KommentModeration();
                $result = $kommentModeration->flagComment($id, $flag);

                return new Response(json_encode([$flag => $result]), 'application/json');
            },
        ],
        [
            'pattern' => 'komments/publish/(:any)',
            'method' => 'POST',
            'action' => function (string $id) {
                $kommentModeration = new KommentModeration();
                $result = $kommentModeration->publishComment($id);
                return new Response(json_encode(['published' => $result]), 'application/json');
            },
        ],
        [
            'pattern' => 'komments/reply/(:any)',
            'method' => 'POST',
            'action' => function (string $id) {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $result = $kommentModeration->replyToComment($id, $formData);

                if (option('mauricerenck.komments.webmentions.sendReplies', false)) {
                    if ($result['created'] === true && $result['inReplyTo']['type'] !== 'comment') {
                        $page = page($result['newComment']['pageuuid']);

                        if ($page !== null) {
                            kirby()->trigger('indieConnector.webmention.send', [
                                'page' => $page,
                                'targetUrl' => $result['inReplyTo']['authorurl'],
                                'sourceUrl' => site()->url('') . '/@/comment/' . $result['newComment']['id'],
                            ]);
                        }
                    }
                }

                return new Response(json_encode($result), 'application/json');
            },
        ],
        [
            'pattern' => 'komments/converter/get-comments',
            'method' => 'GET',
            'action' => function () {
                $migrations = new Migrations();
                $result = $migrations->getListOfAllComments();
                return new Response(json_encode($result), 'application/json');
            },
        ],
        [
            'pattern' => 'komments/converter/convert',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $migrations = new Migrations();
                $result = $migrations->convertSingleComment(comment: $formData['comment'], language: $formData['language'], uuid: $formData['pageUuid']);
                return new Response(json_encode($result), 'application/json');
            },
        ],
    ],
];
