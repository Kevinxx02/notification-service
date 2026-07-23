<?php

declare(strict_types=1);

return [
    'host' => env('RABBITMQ_HOST', 'rabbitmq'),
    'port' => (int) env('RABBITMQ_PORT', 5672),
    'user' => env('RABBITMQ_USER', 'guest'),
    'password' => env('RABBITMQ_PASSWORD', 'guest'),
    'vhost' => env('RABBITMQ_VHOST', '/'),
    'exchange' => env('RABBITMQ_EXCHANGE', 'notification.exchange'),
    'queue' => env('RABBITMQ_QUEUE', 'notification.send'),
    'routing_key' => env('RABBITMQ_ROUTING_KEY', 'notification.send'), ];
