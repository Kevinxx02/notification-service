<?php

declare(strict_types=1);

namespace App\Application\Ports\Out;

use App\Domain\Entities\Notification;

interface NotificationSender
{
    public function send(Notification $notification): void;
}
