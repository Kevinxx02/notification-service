<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Application\SendNotification\NotificationMessageHandler;
use App\Infrastructure\RabbitMQ\RabbitConsumer;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('rabbit:consume')]
#[Description('Consume RabbitMQ messages')]
final class RabbitConsumeCommand extends Command
{
    public function __construct(
        private readonly RabbitConsumer $consumer,
        private readonly NotificationMessageHandler $handler,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('Waiting for messages...');

        $this->consumer->consume($this->handler);

        return self::SUCCESS;
    }
}
