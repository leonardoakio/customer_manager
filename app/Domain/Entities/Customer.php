<?php

namespace App\Domain\Entities;

use App\Domain\Collections\AddressCollection;
use App\Domain\Factories\CustomerFactory;
use App\Domain\ValueObjects\Cns;
use App\Domain\ValueObjects\Cpf;
use App\Domain\Entities\Address;

use DateTimeImmutable;

class Customer
{
    public function __construct(
        private int                   $id,
        private string                $name,
        private string                $motherName,
        private string                $pictureUrl,
        private Cpf                   $document,
        private Cns                   $cns,
        private Address               $address,
        private ?DateTimeImmutable    $createdAt = null,
        private ?DateTimeImmutable    $updatedAt = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return CustomerFactory::fromArray($data);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMotherName(): string
    {
        return $this->motherName;
    }

    public function getDocument(): Cpf
    {
        return $this->document;
    }

    public function getCns(): Cns
    {
        return $this->cns;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getPictureUrl(): string
    {
        return $this->pictureUrl;
    }

    public function addAddress(AddressCollection $addressCollection): void
    {
        $this->address = $addressCollection;
    }
}