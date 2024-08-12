<?php

namespace mauricerenck\Komments;

use Kirby\Http\Response;

return [
    'routes' => [
        [
            'pattern' => 'komments/spam',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->markAsSpam($formData['pageSlug'], $formData['kommentId'], $formData['isSpam']);

                return new Response(json_encode(['message' => 'okay']), 'application/json');
            },
        ],
        [
            'pattern' => 'komments/verify',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->markAsVerified(
                    $formData['pageSlug'],
                    $formData['kommentId'],
                    $formData['isVerified']
                );

                return new Response(json_encode(['message' => 'okay']), 'application/json');
            },
        ],
        [
            'pattern' => 'komments/publish',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->publish($formData['pageSlug'], $formData['kommentId'], $formData['isPublished']);

                return new Response(json_encode(['message' => 'okay']), 'application/json');
            },
        ],
        [
            'pattern' => 'komments/delete',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->delete($formData['pageSlug'], $formData['kommentId']);

                return new Response(json_encode(['message' => 'okay']), 'application/json');
            },
        ],
    ],
];
