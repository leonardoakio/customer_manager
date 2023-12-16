<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class Cns
{
    public function __construct(
        private string $cns
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (strlen($this->cns) !== 15) {
            throw new InvalidArgumentException(
                sprintf(
                    'O número do CNS deve conter 15 dígitos',
                    $this->cns
                )
            );
        }
    }

    public function equals(Cns $otherCns): bool
    {
        return $this->cns === $otherCns->cns;
    }

    public static function fromString(string $cns): self
    {
        return new self($cns);
    }
    public function toString(): string
    {
        return $this->cns;
    }
}
