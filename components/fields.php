<?php

namespace mauricerenck\Komments;

return [
    'kommentType' => [
        'props' => [
        ]
    ],
    'kommentsPending' => [
        'props' => [
            'queuedComments' => function () {
                $kommentUtils = new KommentBaseUtils();
                $pendingComments = $kommentUtils->getPendingKomments();
                return count($pendingComments);
            },
        ]
    ],
    'komments' => [
        'props' => [
            'queuedComments' => function () {
                $kommentUtils = new KommentBaseUtils();
                return $kommentUtils->getPendingKomments();
            },
            'version' => function () {
                $kommentUtils = new KommentBaseUtils();
                return $kommentUtils->getPluginVersion();
            }
        ]
    ]
];
