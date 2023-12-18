<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class PostalCode
{
    public function __construct(
        private ?string $code
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->code !== null && strlen($this->code) !== 8) {
            throw new InvalidArgumentException(
                sprintf(
                    'O número do CEP deve conter 8 dígitos',
                    $this->code
                )
            );
        }
    }

    public function formatAsCep(): string
    {
        return vsprintf('%s%s%s%s%s-%s%s%s', str_split($this->code));
    }

    public function getNumbersOnly(): string
    {
        return preg_replace('/[^0-9]/', '', $this->code);
    }

    public static function fromString(?string $code): ?self
    {
        if ($code !== null) {
            return new self($code);
        }
    
        return null;
    }    
}
