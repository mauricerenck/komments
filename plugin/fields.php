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
                return null;
                // return $kommentModeration->getSiteWideComments('pending');
            },
        ],
    ],
    'CommentsTable' => [
        'props' => [
            'comments' => function () {
                $kommentModeration = new KommentModeration();
                $comments = $kommentModeration->getAllPageComments(pageUuid: $this->model()->uuid());

                return json_decode($comments['comments']);
            },
            'affectedPages' => function () {
                $kommentModeration = new KommentModeration();
                $comments = $kommentModeration->getAllPageComments(pageUuid: $this->model()->uuid());

                return $comments['affectedPages'];
            },
            'columns' => function (?array $userColumns = null) {
                $defaultColumns = ['author', 'content', 'type', 'published', 'spamlevel', 'verified'];
                return $userColumns ?? $defaultColumns;
            },
        ],
    ],
];
