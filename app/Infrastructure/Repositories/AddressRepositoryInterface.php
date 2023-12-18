<?php

namespace App\Infrastructure\Repositories;

interface AddressRepositoryInterface
{
    public function updateAddress(int $customerId, array $addressData): array;
}