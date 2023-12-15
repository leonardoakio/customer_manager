<?php

namespace App\Domain\Entities;

use App\Domain\Factories\CustomerFactory;
use DateTimeImmutable;

class Customer
{
    public function __construct(
        private int                   $id,
        private string                $name,
        private string                $motherName,
        private string                $document,
        private string                $cns,
        private string                $pictureUrl,
        // private ?CustomerAddress      $customerAddress,
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

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getCns(): string
    {
        return $this->cns;
    }

    public function getPictureUrl(): string
    {
        return $this->pictureUrl;
    }


    // public function getPictureUrl(): ?CustomerPlan
    // {
    //     return $this->plan;
    // }
}