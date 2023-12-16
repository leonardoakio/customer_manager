<?php

namespace App\Domain\Factories;

use App\Domain\Entities\Address;
use App\Domain\ValueObjects\PostalCode;
use App\Infrastructure\Helpers\Mapping;
use DateTimeImmutable;

class AddressFactory
{
    use Mapping;

    public static function fromArray(array $data): Address
    {
        $addressData = $data[0];
        
        $postalCode = PostalCode::fromString($addressData['postal_code']);
        
        return  new Address(
            id: self::getIntOrNull($addressData, 'id'),
            address: self::getString($addressData, 'address'),
            number: self::getIntOrNull($addressData, 'number'),
            complement: self::getString($addressData, 'complement'),
            neighborhood: self::getString($addressData, 'neighborhood'),
            city: self::getString($addressData, 'city'),
            state: self::getString($addressData, 'state'),
            postalCode: $postalCode,
            createdAt: new DateTimeImmutable(self::getString($addressData, 'created_at')),
            updatedAt: new DateTimeImmutable(self::getString($addressData, 'updated_at')),
        );
        
    }
}