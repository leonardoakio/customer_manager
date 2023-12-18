<?php

namespace App\Infrastructure\Repositories;

use App\Models\Address as AddressModel;
use InvalidArgumentException;

class AddressRepository implements AddressRepositoryInterface
{
    public function __construct(
        private AddressModel $address,
    ) {
    }

    public function updateAddress(int $customerId, array $addressData): array
    {
        $address = $this->address
        ->join('customers', 'addresses.id', '=', 'customers.address_id')
        ->where('customers.id', $customerId)
        ->select('addresses.*')
        ->first();

        if (empty($address)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Endereço não encontrado para o customer_id: %s',
                    $customerId
                )
            );
        }

        $address->update($addressData);

        return $addressData;
    }
}