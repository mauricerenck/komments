<?php

return [
    'debug' => true,
    'languages' => false,

    'email' => [
        'transport' => [
            'type' => 'smtp',
            'host' => 'localhost',
            'port' => 1025,
            'security' => false
        ]
    ],
    'mauricerenck' => [
        'komments' => [
            'debug' => true,
            'migrations' => [
                'comments' => false,
            ],
            'webmentions.sendReplies' => true,
            'auto-publish-verified' => true,
            'auto-delete-spam' => false,
            'autoDisable.ttl' => 0,
            'privacy' => [
                'storeEmail' => false,
            ],
            'notifications' => [
                'skipSpam' => false,
                'email' => [
                    'enable' => true,
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
                'verification' => [
                    'enabled' => true,
                    'filterUnverified' => true,
                    'ttl' => 1,
                    'secret' => 'my-extremly-secure-secret',
                    'autoPublish' => false,
                    'deletionMode' => 'delete'
                ],
            ],
            'avatar' => [
                'service' => 'initials',
                'size' => 64,
            ]

        ]
    ]
];
