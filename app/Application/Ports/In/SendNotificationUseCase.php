<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\SendNotification\SendNotificationCommand;

interface SendNotificationUseCase
{
    public function execute(SendNotificationCommand $command): void;
}
