<?php
namespace mauricerenck\Komments;

if (option('mauricerenck.komments.comments.disabled', false) === true) {
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
                        $comments = $kommentModeration->getPendingComments(type: 'comment');

                        return [
                            'component' => 'k-komments-view',
                            'title' => 'Komments',
                            'props' => [
                                'queuedKomments' => json_decode($comments['comments']),
                                'affectedPages' => $comments['affectedPages'],
                            ],
                        ];
                    },
                ],
            ],
            'dialogs' => [
                // the key of the dialog defines its routing pattern
                'comment/read/(:any)' => [
                    // dialog callback functions
                    'load' => function ($id) {
                        $kommentModeration = new KommentModeration();
                        $comment = $kommentModeration->getComment($id);
                        return [
                            // what dialog component to use
                            'component' => 'k-komments-details',
                            'props' => [
                                'text' => $comment['content'],
                            ]
                        ];
                    },
                    'submit' => function () {
                        // create todo
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
