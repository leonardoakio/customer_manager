<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Collections\CustomerCollection;
use App\Domain\ValueObjects\CustomerId;
use App\Domain\ValueObjects\Metadata;
use App\Domain\ValueObjects\Pagination;
use App\Models\Customer as CustomerModel;
use App\Models\Customer;
use InvalidArgumentException;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(
        private CustomerModel $customer,
    ) {
    }

    public function getCustomersOverview(?Pagination $pagination = null): array
    {
        $query = $this->customer->with(['addresses']);

        if ($pagination) {
            $pagination->setTotalRecords($query->count());
            $this->applyPagination($query, $pagination);
        }

        $currentPage = $pagination->page();

        $offset = ($currentPage - 1) * $pagination->limit();
        $query->offset($offset);

        $customers = $query->get()->toArray();

        if (empty($customers)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Não foi possível listar os clientes no momento',
                )
            );
        }

        $metadata = new Metadata(
            $pagination->page() ?? 1, 
            $pagination->limit() ?? 20,
            $pagination->totalRecords() ?? 0
        );
        
    
        return [
            'customers' => CustomerCollection::fromArray($customers),
            'metadata' => $metadata->toArray(),
        ];    
    }

    public function getCustomer(CustomerId $customerId): CustomerCollection
    {
        $customers = $this->customer
            ->where('id', $customerId->asInteger())
            ->with(['addresses'])        
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

        return CustomerCollection::fromArray($customers);
    }

    public function createCustomer(array $customerData): Customer
    {        
        if (empty($customerData)) {
            throw new InvalidArgumentException('Sem dados a serem registrados na tabela Customers');
        }

        $createdCustomer = $this->customer->create($customerData);

        return $createdCustomer;
    }

    public function updateCustomer(CustomerId $customerId, array $customerData): array
    {
        $customerId = $customerId->asInteger();

        $existingCustomer = $this->customer->find($customerId);

        if (empty($existingCustomer)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Cliente com ID %s não encontrado',
                    $customerId
                ),
            );
        }

        if (empty($customerData)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Sem dados a serem alterados para o customer_id: %s',
                    $customerId
                )
            );
        }
        
        $this->customer
            ->where('id', $customerId)
            ->update($customerData);

        return $customerData;
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

    private function applyPagination($query, ?Pagination $pagination): void
    {
        $query->orderBy('id', $pagination->orderBy()->asString());

        $query->limit($pagination->limit());
    }
    
}