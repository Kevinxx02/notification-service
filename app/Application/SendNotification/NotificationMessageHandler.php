<?php

declare(strict_types=1);

namespace App\Application\SendNotification;

use App\Application\Ports\In\SendNotificationUseCase;
use App\Infrastructure\RabbitMQ\Contracts\MessageHandler;

final readonly class NotificationMessageHandler implements MessageHandler
{
    public function __construct(
        private SendNotificationUseCase $useCase,
    ) {}

    public function handle(string $payload): void
    {
        /** @var array{
         * notificationId:string,
         * recipient:string,
         * subject:string,
         * message:string
         * } $message
         */
        $message = json_decode(
            json: $payload,
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );

        $command = new SendNotificationCommand(
            notificationId: $message['notificationId'],
            recipient: $message['recipient'],
            subject: $message['subject'],
            message: $message['message'],
        );

        $this->useCase->execute($command);
    }
}
