<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Collections\CustomerCollection;
use App\Domain\ValueObjects\CustomerId;

interface CustomerRepositoryInterface
{
    public function getCustomersOverview(): CustomerCollection;
    public function getCustomer(CustomerId $customerId): array;

}