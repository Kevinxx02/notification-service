<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

final readonly class Subject
{
    private function __construct(
        private string $value,
    ) {
        if ($value === '') {
            throw new \InvalidArgumentException('Subject cannot be empty.');
        }

        if (mb_strlen($value) > 255) {
            throw new \InvalidArgumentException('Subject is too long.');
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
