<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Collections\CustomerCollection;
use App\Domain\Entities\Customer;
use App\Domain\ValueObjects\CustomerId;
use App\Domain\ValueObjects\Metadata;
use App\Domain\ValueObjects\Pagination;
use App\Models\Customer as CustomerModel;
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
            $pagination->page(),
            $pagination->limit(),
            $pagination->totalRecords()
        );
    
        return [
            'customers' => CustomerCollection::fromArray($customers),
            'metadata' => $metadata->toArray(),
        ];    
    }

    public function getCustomer(CustomerId $customerId): array
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

    private function applyPagination($query, ?Pagination $pagination): void
    {
        $query->orderBy('id', $pagination->orderBy()->asString());

        $query->limit($pagination->limit());
    }
    
}