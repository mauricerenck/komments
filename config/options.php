<?php

return [
    'debug' => false,
    'enable-webmention-support' => true,
    'webmention-auto-publish' => true,
    'komment-auto-publish' => false,
    'auto-delete-spam' => false,
    'auto-disable-komments' => 0,
    'auto-disable-komments-datefield' => 'date',
    'komment-icon-like' => '❤️',
    'komment-icon-reply' => '💬',
    'komment-icon-repost' => '♻️',
    'komment-icon-mention' => '♻️',
    'komment-icon-verified' => '✅',
    'replyClassNames' => '',
    'form.submit.classNames' => 'button button-tiny button-primary',
    'form.twitter.classNames' => 'button button-tiny button-outlined share komment-share-twitter',
    'form.mastodon.classNames' => 'button button-tiny button-outlined share komment-share-mastodon',
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
