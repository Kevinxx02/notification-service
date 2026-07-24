<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

final class RabbitHeaders
{
    public const RETRY_COUNT = 'retry-count';

    private function __construct() {}
}
