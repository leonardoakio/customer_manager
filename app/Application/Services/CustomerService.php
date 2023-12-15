<?php

namespace App\Application\Services;

use App\Domain\Collections\CustomerCollection;
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
}