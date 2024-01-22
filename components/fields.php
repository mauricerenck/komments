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
                $pendingComments = $kommentUtils->getPendingCommentCount();
                return $pendingComments;
            },
        ]
    ],
    'komments' => [
        'props' => [
            'queuedComments' => function () {
                $kommentUtils = new KommentBaseUtils();
                return $kommentUtils->getPendingKomments();
            },
        ]
    ]
];
