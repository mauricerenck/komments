<?php
namespace mauricerenck\Komments;

if (option('mauricerenck.komments.panel.enabled', true) === false) {
    return null;
}

return [
    'komments' => function () {
        return [
            'label' => 'Komments',
            'icon' => 'chat',
            'menu' => true,
            'link' => 'komments',
            'views' => [
                [
                    'pattern' => 'komments',
                    'action' => function () {
                        $kommentModeration = new KommentModeration();
                        $comments = $kommentModeration->getPendingComments();

                        return [
                            'component' => 'k-komments-view',
                            'title' => 'Komments',
                            'props' => [
                                'queuedKomments' => json_decode($comments['comments']),
                                'affectedPages' => $comments['affectedPages'],
                                'webmentions' => option('mauricerenck.komments.panel.webmentions', false),
                            ],
                        ];
                    },
                ],
            ],
            'dialogs' => [
                'comment/read/(:any)' => [
                    'load' => function ($id) {
                        $kommentModeration = new KommentModeration();
                        $comment = $kommentModeration->getComment($id);
                        return [
                            'component' => 'k-komments-details',
                            'props' => [
                                'text' => $comment['content'],
                            ]
                        ];
                    },
                    'submit' => function () {
                        return true;
                    }
                ],
                'comment/delete/(:any)' => [
                    'load' => function (string $id) {
                        return [
                            'component' => 'k-remove-dialog',
                            'props' => [
                                'text' => 'Do you really want to delete this comment?'
                            ]
                        ];
                    },
                    'submit' => function (string $id) {
                        $kommentModeration = new KommentModeration();
                        $result = $kommentModeration->deleteComment($id);

                        return $result;
                    }
                ],
            ]
        ];
    },
];
