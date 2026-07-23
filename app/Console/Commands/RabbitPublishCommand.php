<?php

namespace App\Console\Commands;

use App\Infrastructure\RabbitMQ\RabbitPublisher;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

#[Signature('rabbit:publish')]
#[Description('Publish a test notification to RabbitMQ')]
class RabbitPublishCommand extends Command
{
    public function __construct(
        private readonly RabbitPublisher $publisher,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $payload = [
            'notificationId' => Uuid::uuid7()->toString(),
            'recipient' => 'test@example.com',
            'subject' => 'Hello',
            'message' => 'Hello World',
        ];

        $this->publisher->publish(
            json_encode(
                $payload,
                JSON_THROW_ON_ERROR,
            ),
        );

        $this->info('Notification published.');

        return self::SUCCESS;
    }
}
