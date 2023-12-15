<?php

namespace App\Domain\Entities;

use App\Domain\Factories\AddressFactory;
use App\Domain\ValueObjects\PostalCode;
use DateTimeImmutable;

class Address
{
    public function __construct(
        private int                   $id,
        private string                $address,
        private int                   $number,
        private string                $complement,
        private string                $neighborhood,
        private string                $city,
        private string                $state,
        private PostalCode            $postalCode,
        private ?DateTimeImmutable    $createdAt = null,
        private ?DateTimeImmutable    $updatedAt = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return AddressFactory::fromArray($data);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getComplement(): string
    {
        return $this->complement;
    }

    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getPostalCode(): PostalCode
    {
        return $this->postalCode;
    }

    public function toArray(): array
    {
        return [
            'address' => $this->address,
            'number' => $this->number,
            'complement' => $this->complement,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postalCode->getNumbersOnly()

        ];
    }
}