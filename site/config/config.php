<?php

return [
    'debug' => true,
    'languages' => true,

    'email' => [
        'transport' => [
            'type' => 'smtp',
            'host' => 'localhost',
            'port' => 1025,
            'security' => false
        ]
    ],
    'mauricerenck.komments.notifications.email.enable' => true,
    'mauricerenck.komments.notifications.email.sender' => 'test@domain.tld',
    'mauricerenck.komments.notifications.email.emailReceiverList' => ['test@domain.tld'],
    'mauricerenck' => [
        'komments' => [
            'migrations' => false,
            'auto-publish-verified' => true,
            'auto-delete-spam' => false,
            'autoDisable.ttl' => 0,
            'privacy' => [
                'storeEmail' => false,
            ],
            'notifications' => [
                'email' => [
                    'enable' => false,
                    'sender' => 'test@domain.tld',
                    'emailReceiverList' => ['test@domain.tld'],
                ]
            ],
            'moderation' => [
                'autoPublish' => [
                    'test@phpunit.de'
                ]
            ],
            'storage' => [
                // 'type' => 'markdown',
                'type' => 'sqlite',
                'sqlitePath' => '.sqlite',
            ],
            'spam' => [
                'delete' => false,
            ],
        ]
    ]
];
