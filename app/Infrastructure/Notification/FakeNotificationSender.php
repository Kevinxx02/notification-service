<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification;

use App\Application\Ports\Out\NotificationSender;
use App\Domain\Entities\Notification;

final class FakeNotificationSender implements NotificationSender
{
    public function send(Notification $notification): void
    {
        dump($notification);

        logger()->info('Notification sent');
    }
}
