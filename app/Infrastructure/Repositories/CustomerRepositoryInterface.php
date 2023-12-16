<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Customer;
use App\Domain\ValueObjects\CustomerId;
use App\Domain\ValueObjects\Pagination;

interface CustomerRepositoryInterface
{
    public function getCustomersOverview(?Pagination $pagination = null): array;

    public function getCustomer(CustomerId $customerId): array;

    public function updateCustomer(Customer $customerData): array;

    public function deleteCustomer(CustomerId $customerId): bool;
}