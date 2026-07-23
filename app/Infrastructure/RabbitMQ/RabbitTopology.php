<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

final readonly class RabbitTopology
{
    public function __construct(
        private RabbitConnection $connection,
    ) {}

    public function initialize(): void
    {
        $channel = $this->connection->channel();

        $config = config('rabbitmq');

        $channel->exchange_declare(
            exchange: $config['exchange'],
            type: 'direct',
            passive: false,
            durable: true,
            auto_delete: false,
        );

        $channel->queue_declare(
            queue: $config['queue'],
            passive: false,
            durable: true,
            exclusive: false,
            auto_delete: false,
        );

        $channel->queue_bind(
            queue: $config['queue'],
            exchange: $config['exchange'],
            routing_key: $config['routing_key'],
        );
    }
}
