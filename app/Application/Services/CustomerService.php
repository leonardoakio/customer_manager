<?php

namespace App\Application\Services;

use App\Domain\Collections\CustomerCollection;
use App\Domain\ValueObjects\CustomerId;
use App\Infrastructure\Repositories\CustomerRepositoryInterface;

class CustomerService
{
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository,
    ) {}

    public function getCustomerPanel(): CustomerCollection
    {
        return $this->customerRepository->getCustomersOverview();
    }

    public function getSingleCustomer(CustomerId $customerId): array
    {
        return $this->customerRepository->getCustomer($customerId);
    }
}