<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

final readonly class Message
{
    private function __construct(
        private string $value,
    ) {
        if ($value === '') {
            throw new \InvalidArgumentException('Message cannot be empty.');
        }
    }

    public static function fromString(string $value): self
    {
        return new self(trim($value));
    }

    public function value(): string
    {
        return $this->value;
    }
}
