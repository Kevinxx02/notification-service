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
        private RetryPublisher $retryPublisher,
    ) {}

    public function consume(MessageHandler $handler): void
    {
        $this->topology->initialize();

        $channel = $this->connection->channel();

        $config = config('rabbitmq');

        $channel->basic_consume(
            queue: $config['queues']['notification'],
            consumer_tag: '',
            no_local: false,
            no_ack: false,
            exclusive: false,
            nowait: false,
            callback: function (AMQPMessage $message) use ($handler): void {
                try {
                    $this->process($message, $handler);

                    $message->ack();
                } catch (\Throwable $exception) {
                    $this->retryPublisher->publish($message);
                    $message->ack();
                }
            },
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    private function process(
        AMQPMessage $message,
        MessageHandler $handler,
    ): void {
        $handler->handle($message->getBody());
    }
}
