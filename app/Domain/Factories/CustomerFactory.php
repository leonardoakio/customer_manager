<?php

namespace App\Domain\Factories;

use App\Domain\Collections\AddressCollection;
use App\Domain\Entities\Customer;
use App\Domain\ValueObjects\Cns;
use App\Domain\ValueObjects\Cpf;
use App\Infrastructure\Helpers\Mapping;
use DateTimeImmutable;

class CustomerFactory
{
    use Mapping;

    public static function fromArray(array $data): Customer
    {        
        $addressCollection = AddressCollection::fromArray($data['addresses']);

        $customer = new Customer(
            id: self::getIntOrNull($data, 'id'),
            name: self::getString($data, 'name'),
            motherName: self::getString($data, 'mother_name'),
            pictureUrl: self::getString($data, 'picture_url'),
            document: new Cpf($data['document']),
            cns: Cns::fromString($data['cns']),
            address: $addressCollection->items()[0],
            createdAt: new DateTimeImmutable(self::getString($data, 'created_at')),
            updatedAt: new DateTimeImmutable(self::getString($data, 'updated_at')),
        );

        return $customer;
    }
}