<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

final class RabbitConnection
{
    private ?AMQPStreamConnection $connection = null;

    private ?AMQPChannel $channel = null;

    public function channel(): AMQPChannel
    {
        if ($this->channel instanceof AMQPChannel) {
            return $this->channel;
        }

        $config = config('rabbitmq');

        $this->connection = new AMQPStreamConnection(
            host: $config['host'],
            port: $config['port'],
            user: $config['user'],
            password: $config['password'],
            vhost: $config['vhost']
        );

        $this->channel = $this->connection->channel();

        return $this->channel;
    }

    public function disconnect(): void
    {
        $this->channel?->close();
        $this->connection?->close();

        $this->channel = null;
        $this->connection = null;
    }
}
