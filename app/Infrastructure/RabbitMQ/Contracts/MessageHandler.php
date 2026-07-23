<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ\Contracts;

interface MessageHandler
{
    public function handle(string $payload): void;
}
