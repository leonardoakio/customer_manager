<?php

namespace App\Infrastructure\Repositories;
use App\Models\Address as AddressModel;

interface AddressRepositoryInterface
{
    public function createAddress(array $addressData): AddressModel;

    public function updateAddress(int $customerId, array $addressData): array;
}