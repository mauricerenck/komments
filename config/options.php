<?php

return [
    'debug' => false,
    'enable-webmention-support' => true,
    'webmention-auto-publish' => true,
    'komment-auto-publish' => false,
    'send-mention-on-update' => true,
    'send-limit-to-templates' => [],
    'send-mention-url-fields' => [
        'text'
    ],
    'send-to-mastodon-on-publish' => false,
    'mastodon-bearer' => '',
    'mastodon-instance-url' => 'https://mastodon.social/api/v1/statuses',
    'mastodon-text-field' => 'mastodonTeaser',
    'ping-archiveorg' => false,
    'auto-delete-spam' => true,
    'auto-disable-komments' => 0,
    'auto-disable-komments-datefield' => 'date',
    'komment-icon-like' => '❤️',
    'komment-icon-reply' => '💬',
    'komment-icon-repost' => '♻️',
    'komment-icon-mention' => '♻️',
];
