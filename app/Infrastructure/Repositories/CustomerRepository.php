<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Collections\CustomerCollection;
use App\Models\Customer as CustomerModel;
use InvalidArgumentException;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(
        private CustomerModel $customer,
    ) {
    }

    public function getCustomersOverview(): CustomerCollection
    {
        $customers = $this->customer
            ->get()
            ->toArray();

        if (empty($customers)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Não foi possível listar os clientes no momento',
                )
            );
        }

        return CustomerCollection::fromArray($customers);
    }
}