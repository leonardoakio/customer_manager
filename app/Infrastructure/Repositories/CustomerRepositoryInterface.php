<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Collections\CustomerCollection;
use App\Domain\Entities\Customer;
use App\Domain\ValueObjects\CustomerId;
use App\Domain\ValueObjects\Pagination;

interface CustomerRepositoryInterface
{
    public function getCustomersOverview(?Pagination $pagination = null): array;

    public function getCustomer(CustomerId $customerId): CustomerCollection;

    public function updateCustomer(CustomerId $customerId, array $customerData): array;

    public function deleteCustomer(CustomerId $customerId): bool;
}