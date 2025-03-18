<?php

return [
    'debug' => false,
    'commentMigration' => true,
    'migrations' => [
        'disabled' => false,
        'comments' => false
    ],
    'spam' => [
        'akismet' => false,
        'akismet_api_key' => '',
        'sensibility' => 60,
        'delete' => true,
    ],

    'panel' => [
        'enabled' => true,
        'webmentions' => false,
    ],

    'storage' => [
        'type' => 'sqlite',
        'sqlitePath' => '.sqlite/',
    ],

    'webmentions' => [
        'publish' => true,
        'enabled' => true,
    ],

    'moderation' => [
        'autoPublish' => [],
        'publishVerified' => false,
    ],

    'privacy' => [
        'storeEmail' => false,
    ],

    'autoDisable.ttl' => 0,
    'autoDisable.datefield' => 'date',

    'form.submit.classNames' => 'button button-primary',

    'notifications' => [
        'cronSecret' => '',
        'email' => [
            'enable' => false,
            'sender' => 'user@domain.tld',
            'emailReceiverList' => [],
            'notificationMode' => 'instant'
        ]
    ]
];
