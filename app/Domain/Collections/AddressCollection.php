<?php

namespace App\Domain\Collections;

use App\Domain\Entities\Address;

class AddressCollection
{
    private array $items;

    public function __construct(Address ...$address)
    {
        $this->items = $address;
    }

    public static function fromArray(array $data): AddressCollection
    {
        return new self(
            ...array_map(function (array $address) {
                return Address::fromArray($address);
            }, $data)
        );
    }

    public function items(): array
    {
        return $this->items;
    }
}