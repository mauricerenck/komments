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
                        $comments = $kommentModeration->getComments(type: 'comment');

                        return [
                            'component' => 'k-komments-view',
                            'title' => 'Komments',
                            'props' => [
                                'queuedKomments' => $comments['comments'],
                                'affectedPages' => $comments['affectedPages'],
                            ],
                        ];
                    },
                ],
            ],
        ];
    },
];
