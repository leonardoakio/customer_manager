<?php

namespace App\Application\Services;

use App\Domain\ValueObjects\CustomerId;
use App\Domain\ValueObjects\Pagination;
use App\Infrastructure\Repositories\CustomerRepositoryInterface;

class CustomerService
{
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository,
    ) {}

    public function getCustomerPanel(?Pagination $pagination): array
    {
        return $this->customerRepository->getCustomersOverview($pagination);
    }

    public function getSingleCustomer(CustomerId $customerId): array
    {
        return $this->customerRepository->getCustomer($customerId);
    }
}