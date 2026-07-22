<?php

declare(strict_types=1);

namespace App\Application\SendNotification;

use App\Application\Ports\In\SendNotificationUseCase;
use App\Application\Ports\Out\NotificationSender;
use App\Domain\Entities\Notification;
use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\NotificationId;
use App\Domain\ValueObjects\Recipient;
use App\Domain\ValueObjects\Subject;

final class SendNotificationHandler implements SendNotificationUseCase
{
    public function __construct(
        private readonly NotificationSender $notificationSender,
    ) {}

    public function execute(SendNotificationCommand $command): void
    {
        $notification = Notification::create(
            NotificationId::generate(),
            Recipient::fromString($command->recipient),
            Subject::fromString($command->subject),
            Message::fromString($command->message),
        );

        $this->notificationSender->send($notification);
    }
}
