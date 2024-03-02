<?php

namespace mauricerenck\Komments;

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
                        return [
                            'component' => 'k-komments-view',
                            'title' => 'Komments',
                            'props' => [
                                'queuedKomments' => function () {
                                    $kommentModeration = new KommentModeration();
                                    return $kommentModeration->getSiteWideComments('pending');
                                },
                                'kirbyVersion' => kirby()->version(),
                            ],
                        ];
                    },
                ],
            ],
        ];
    },
];
