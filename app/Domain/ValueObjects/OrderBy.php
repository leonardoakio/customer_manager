<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class OrderBy
{
    public function __construct(
        private ?string $orderBy = null
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->orderBy !== null && !in_array($this->orderBy, ["asc", "desc"])) {
            throw new InvalidArgumentException(
                sprintf(
                    "A ordenação não é válida: %s", 
                    $this->orderBy
                )
            );
        }
    }
    

    public static function fromDirection(string $direction): ?self
    {
        return new self($direction);
    }
    
    public static function fromString(string $orderBy): ?self
    {
        return new self($orderBy);
    }

    public function asString(): ?string
    {
        return $this->orderBy;
    }
}
