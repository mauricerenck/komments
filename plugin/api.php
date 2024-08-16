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
                return new Response(json_encode($result), 'application/json');
            },
        ],
    ],
];
