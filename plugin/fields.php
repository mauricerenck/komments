<?php

namespace mauricerenck\Komments;

return [
    'kommentType' => [
        'props' => [],
    ],
    'kommentsPending' => [
        'props' => [
            'queuedComments' => function () {
                $storage = StorageFactory::create();
                $comments = $storage->getCommentsOfSite();
                $unpublishedComments = $comments->filterBy('published', false);

                return $unpublishedComments->count();
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
                $defaultColumns = ['author', 'content', 'spamlevel', 'verified', 'published', 'type'];
                return $userColumns ?? $defaultColumns;
            },
            'webmentions' => function (bool $webmentions = true) {
                return $webmentions;
            },
        ],
    ],
];
