<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class CustomerId
{
    public function __construct(
        private int $customerId
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->customerId <= 0) {
            throw new InvalidArgumentException(
                'O customerId é inválido',
                sprintf('CustomerId [%s] inválido', $this->customerId)
            );
        }
    }

    public static function fromInteger(int $customerId): self
    {
        return new self($customerId);
    }

    public static function fromString(string $customerId): self
    {
        return new self((int)$customerId);
    }

    public function asInteger(): int
    {
        return $this->customerId;
    }
}