<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;

final readonly class RabbitPublisher
{
    public function __construct(
        private RabbitConnection $connection,
        private RabbitTopology $topology,
    ) {}

    public function publish(
        string $payload,
        string $routingKey,
    ): void {

        $this->topology->initialize();

        $config = config('rabbitmq');

        $message = new AMQPMessage(
            $payload,
            [
                'content_type' => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            ],
        );

        $this->connection
            ->channel()
            ->basic_publish(
                $message,
                $config['exchange'],
                $routingKey,
            );
    }

    public function republish(
        AMQPMessage $message,
        string $routingKey,
    ): void {
        $config = config('rabbitmq');

        $this->connection
            ->channel()
            ->basic_publish(
                $message,
                $config['exchange'],
                $routingKey,
            );

    }
}
