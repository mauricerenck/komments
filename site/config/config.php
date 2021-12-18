<?php

return [
    'debug' => true,
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
            'auto-delete-spam' => false,
            'auto-disable-komments' => 0,
        ]
    ]
];
