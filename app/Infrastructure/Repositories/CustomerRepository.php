<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Collections\CustomerCollection;
use App\Domain\Entities\Customer;
use App\Domain\ValueObjects\CustomerId;
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

    public function getCustomer(CustomerId $customerId): array
    {
        $customers = $this->customer
            ->where('id', $customerId->asInteger())
            ->get()
            ->toArray();

        if (empty($customers)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Não foi possível listar o customer_id: %s',
                    $customerId->asInteger()
                ),
            );
        }

        return $customers;
    }

    public function updateCustomer(Customer $customer): array
    {
        $customerId = $customer->getId();

        $existingCustomer = $this->customer->find($customerId);

        if (empty($existingCustomer)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Cliente com ID %s não encontrado',
                    $customerId
                ),
            );
        }

        $updateData = [
            'name' => $customer->getName(),
            'mother_name' => $customer->getMotherName(),
            'document' => $customer->getDocument(),
            'cns' => $customer->getCns(),
            'picture_url' => $customer->getPictureUrl()
        ];

        $updateData = array_filter($updateData);

        if (empty($updateData)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Sem dados a serem altardos para o customer_id: %s',
                    $customerId
                )
            );
        }
        
        $this->customer
        ->where('id', $customerId)
        ->update($updateData);

        return $updateData;
    }

    public function deleteCustomer(CustomerId $customerId): bool
    {
        $existingCustomer = $this->customer->find($customerId->asInteger());

        if (empty($existingCustomer)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Cliente com ID %s não encontrado',
                    $customerId->asInteger()
                ),
            );
        }

        $existingCustomer->delete();

        return true;
    }
}