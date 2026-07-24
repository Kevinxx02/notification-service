<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final readonly class RabbitTopology
{
    public function __construct(
        private RabbitConnection $connection,
    ) {}

    public function initialize(): void
    {
        $channel = $this->connection->channel();

        $this->declareExchange($channel);

        $this->declareNotificationQueue($channel);

        $this->declareRetryQueue($channel);

        $this->declareDeadQueue($channel);
    }

    private function declareExchange(AMQPChannel $channel): void
    {
        $config = config('rabbitmq');

        $channel->exchange_declare(
            exchange: $config['exchange'],
            type: 'direct',
            passive: false,
            durable: true,
            auto_delete: false,
        );
    }

    private function declareNotificationQueue(
        AMQPChannel $channel,
    ): void {
        $config = config('rabbitmq');

        $this->declareQueue(
            channel: $channel,
            queue: $config['queues']['notification'],
        );

        $this->bindQueue(
            channel: $channel,
            queue: $config['queues']['notification'],
            routingKey: $config['routing_keys']['notification'],
        );
    }

    private function declareRetryQueue(
        AMQPChannel $channel,
    ): void {
        $config = config('rabbitmq');

        $arguments = [

            'x-message-ttl' => $config['retry']['ttl'],

            'x-dead-letter-exchange' => $config['exchange'],

            'x-dead-letter-routing-key' => $config['routing_keys']['notification'],

        ];

        $this->declareQueue(
            channel: $channel,
            queue: $config['queues']['retry'],
            arguments: $arguments,
        );

        $this->bindQueue(
            channel: $channel,
            queue: $config['queues']['retry'],
            routingKey: $config['routing_keys']['retry'],
        );
    }

    private function declareDeadQueue(
        AMQPChannel $channel,
    ): void {
        $config = config('rabbitmq');

        $this->declareQueue(
            channel: $channel,
            queue: $config['queues']['dead'],
        );

        $this->bindQueue(
            channel: $channel,
            queue: $config['queues']['dead'],
            routingKey: $config['routing_keys']['dead'],
        );
    }

    private function declareQueue(
        AMQPChannel $channel,
        string $queue,
        array $arguments = [],
    ): void {
        $channel->queue_declare(
            queue: $queue,
            passive: false,
            durable: true,
            exclusive: false,
            auto_delete: false,
            nowait: false,
            arguments: new AMQPTable($arguments),
        );
    }

    private function bindQueue(
        AMQPChannel $channel,
        string $queue,
        string $routingKey,
    ): void {
        $config = config('rabbitmq');

        $channel->queue_bind(
            queue: $queue,
            exchange: $config['exchange'],
            routing_key: $routingKey,
        );
    }
}
