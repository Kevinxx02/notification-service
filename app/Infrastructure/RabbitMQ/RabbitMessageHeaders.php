<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

final class RabbitMessageHeaders
{
    private function __construct() {}

    public static function retryCount(
        AMQPMessage $message,
    ): int {
        $headers = self::headers($message);

        return (int) ($headers[RabbitHeaders::RETRY_COUNT] ?? 0);
    }

    /**
     * @return array<string, mixed>
     */
    private static function headers(
        AMQPMessage $message,
    ): array {
        $properties = $message->get_properties();

        if (
            ! isset($properties['application_headers']) ||
            ! $properties['application_headers'] instanceof AMQPTable
        ) {
            return [];
        }

        return $properties['application_headers']->getNativeData();
    }
}
