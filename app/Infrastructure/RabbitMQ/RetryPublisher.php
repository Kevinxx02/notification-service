<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;

final readonly class RetryPublisher
{
    public function __construct(
        private RabbitPublisher $publisher,
    ) {}

    public function publish(AMQPMessage $message): void
    {
        $this->publisher->publish(
            $message,
            config('rabbitmq.routing_keys.retry'),
        );
    }
}
