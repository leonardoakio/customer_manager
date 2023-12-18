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
        $postalCode = PostalCode::fromString($data['postal_code']);

        return  new Address(
            id: self::getIntOrNull($data, 'id'),
            address: self::getString($data, 'address'),
            number: self::getIntOrNull($data, 'number'),
            complement: self::getString($data, 'complement'),
            neighborhood: self::getString($data, 'neighborhood'),
            city: self::getString($data, 'city'),
            state: self::getString($data, 'state'),
            postalCode: $postalCode,
            createdAt: new DateTimeImmutable(self::getString($data, 'created_at')),
            updatedAt: new DateTimeImmutable(self::getString($data, 'updated_at')),
        );
        
    }
}