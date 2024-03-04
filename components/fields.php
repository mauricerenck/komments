<?php

namespace mauricerenck\Komments;

return [
    'kommentType' => [
        'props' => [],
    ],
    'kommentsPending' => [
        'props' => [
            'queuedComments' => function () {
                $kommentUtils = new KommentBaseUtils();
                $pendingComments = $kommentUtils->getSiteWideCommentCount('pending');
                return $pendingComments;
            },
        ],
    ],
    'komments' => [
        'props' => [
            'queuedComments' => function () {
                $kommentModeration = new KommentModeration();
                return $kommentModeration->getSiteWideComments('pending');
            },
        ],
    ],
];
