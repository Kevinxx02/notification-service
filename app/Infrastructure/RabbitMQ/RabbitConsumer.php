<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

use App\Infrastructure\RabbitMQ\Contracts\MessageHandler;
use PhpAmqpLib\Message\AMQPMessage;

final readonly class RabbitConsumer
{
    public function __construct(
        private RabbitConnection $connection,
        private RabbitTopology $topology,
    ) {}

    public function consume(MessageHandler $handler): void
    {
        $this->topology->initialize();

        $channel = $this->connection->channel();

        $config = config('rabbitmq');

        $channel->basic_consume(
            queue: $config['queue'],
            consumer_tag: '',
            no_local: false,
            no_ack: false,
            exclusive: false,
            nowait: false,
            callback: function (AMQPMessage $message) use ($handler): void {
                $handler->handle($message->getBody());

                $message->ack();
            },
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
