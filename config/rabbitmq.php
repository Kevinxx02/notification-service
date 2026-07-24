<?php

declare(strict_types=1);

return [

    'host' => env('RABBITMQ_HOST', 'rabbitmq'),

    'port' => (int) env('RABBITMQ_PORT', 5672),

    'user' => env('RABBITMQ_USER', 'guest'),

    'password' => env('RABBITMQ_PASSWORD', 'guest'),

    'vhost' => env('RABBITMQ_VHOST', '/'),

    'exchange' => env(
        'RABBITMQ_EXCHANGE',
        'notification.exchange',
    ),

    'queues' => [

        'notification' => env(
            'RABBITMQ_NOTIFICATION_QUEUE',
            'notification.send',
        ),

        'retry' => env(
            'RABBITMQ_RETRY_QUEUE',
            'notification.retry',
        ),

        'dead' => env(
            'RABBITMQ_DEAD_QUEUE',
            'notification.dead',
        ),

    ],

    'routing_keys' => [

        'notification' => env(
            'RABBITMQ_NOTIFICATION_ROUTING_KEY',
            'notification.send',
        ),

        'retry' => env(
            'RABBITMQ_RETRY_ROUTING_KEY',
            'notification.retry',
        ),

        'dead' => env(
            'RABBITMQ_DEAD_ROUTING_KEY',
            'notification.dead',
        ),

    ],

    'retry' => [

        'ttl' => (int) env(
            'RABBITMQ_RETRY_TTL',
            30000,
        ),

    ],

];
