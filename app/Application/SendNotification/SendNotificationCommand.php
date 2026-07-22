<?php

declare(strict_types=1);

namespace App\Application\SendNotification;

final readonly class SendNotificationCommand
{
    public function __construct(
        public string $notificationId,
        public string $recipient,
        public string $subject,
        public string $message,
    ) {}
}
