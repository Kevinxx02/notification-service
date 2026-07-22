<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

final readonly class Recipient
{
    private function __construct(
        private string $value,
    ) {
        if ($value === '') {
            throw new \InvalidArgumentException('Recipient cannot be empty.');
        }

        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid recipient email.');
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
