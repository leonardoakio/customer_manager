<?php

namespace App\Domain\Collections;

use App\Domain\Entities\Customer;

class CustomerCollection
{
    private array $items;

    public function __construct(Customer ...$customer)
    {
        $this->items = $customer;
    }

    public static function fromArray(array $data): CustomerCollection
    {
        return new self(
            ...array_map(function (array $customer) {
                return Customer::fromArray($customer);
            }, $data)
        );
    }

    public function items(): array
    {
        return $this->items;
    }
}