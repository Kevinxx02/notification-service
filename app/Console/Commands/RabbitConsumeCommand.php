<?php

namespace App\Console\Commands;

use App\Application\Ports\In\SendNotificationUseCase;
use App\Application\SendNotification\SendNotificationCommand;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('rabbit:consume')]
#[Description('Consume RabbitMQ messages')]

class RabbitConsumeCommand extends Command
{
    public function __construct(
        private readonly SendNotificationUseCase $useCase
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $command = new SendNotificationCommand(
            notificationId: '1',
            recipient: 'test@example.com',
            subject: 'Hello',
            message: 'Hello World',
        );

        $this->useCase->execute($command);

        return self::SUCCESS;
    }
}
