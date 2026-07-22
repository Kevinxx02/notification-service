<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\NotificationId;
use App\Domain\ValueObjects\Recipient;
use App\Domain\ValueObjects\Subject;

final class Notification
{
    private function __construct(
        private NotificationId $id,
        private Recipient $recipient,
        private Subject $subject,
        private Message $message,
    ) {}

    public static function create(
        NotificationId $id,
        Recipient $recipient,
        Subject $subject,
        Message $message,
    ): self {
        return new self(
            $id,
            $recipient,
            $subject,
            $message,
        );
    }

    public function id(): NotificationId
    {
        return $this->id;
    }

    public function recipient(): Recipient
    {
        return $this->recipient;
    }

    public function subject(): Subject
    {
        return $this->subject;
    }

    public function message(): Message
    {
        return $this->message;
    }
}
