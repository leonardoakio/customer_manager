<?php

namespace App\Domain\ValueObject;

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

    public static function fromInteger(int $userId): self
    {
        return new self($userId);
    }

    public static function fromString(string $userId): self
    {
        return new self((int)$userId);
    }

    public function asInteger(): int
    {
        return $this->customerId;
    }
}