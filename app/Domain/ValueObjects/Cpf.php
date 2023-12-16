<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class Cpf
{
    public function __construct(
        private string $cpf
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (strlen($this->cpf) !== 11) {
            throw new InvalidArgumentException(
                sprintf(
                    'O numero do CNS deve conter 15 digitos',
                    $this->cpf
                )
            );
        }
    }

    public function format(): string
    {
        return vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($this->cpf));
    }

    public function getNumbers(): string
    {
        return preg_replace('/[^0-9]/', '', $this->cpf);
    }

    public function getCheckDigits(): string
    {
        return substr($this->cpf, -2);
    }

    public function equals(CPF $otherCpf): bool
    {
        return $this->cpf === $otherCpf->cpf;
    }

    public static function fromString(string $cpf): self
    {
        return new self($cpf);
    }

    public function toString(): string
    {
        return $this->cpf;
    }
}