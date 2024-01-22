<?php

namespace mauricerenck\Komments;

return [
    'komments' => function ($kirby) {
        return [
            'label' => 'Komments',
            'icon' => 'chat',
            'menu' => true,
            'link' => 'komments',
            'views' => [
                [
                    'pattern' => 'komments',
                    'action' => function () {
                        return [
                            'component' => 'k-komments-view',
                            'title' => 'Komments',
                            'props' => [
                                'queuedKomments' => function () {
                                    $kommentUtils = new KommentBaseUtils();
                                    return $kommentUtils->getPendingKomments();
                                },
                            ],
                        ];
                    }
                ]
            ]
        ];
    }
];
