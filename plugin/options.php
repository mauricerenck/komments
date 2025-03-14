<?php

return [
    'debug' => false,
    'commentMigration' => true,
    'migrations' => [
        'disabled' => false,
        'comments' => true
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

    'auto-disable-komments' => 0,
    'auto-disable-komments-datefield' => 'date',

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
