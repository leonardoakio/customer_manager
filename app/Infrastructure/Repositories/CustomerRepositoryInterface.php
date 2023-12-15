<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Collections\CustomerCollection;
use App\Domain\Entities\Customer;
use App\Domain\ValueObjects\CustomerId;

interface CustomerRepositoryInterface
{
    public function getCustomersOverview(): CustomerCollection;

    public function getCustomer(CustomerId $customerId): array;

    public function updateCustomer(Customer $customerData): array;

    public function deleteCustomer(CustomerId $customerId): bool;
}