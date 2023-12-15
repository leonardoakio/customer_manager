<?php

namespace App\Domain\Factories;

use App\Domain\Entities\Customer;
use App\Infrastructure\Helpers\Mapping;
use DateTimeImmutable;

class CustomerFactory
{
    use Mapping;

    public static function fromArray(array $data): Customer
    {
        return new Customer(
            id: self::getIntOrNull($data, 'id'),
            name: self::getString($data, 'name'),
            motherName: self::getString($data, 'mother_name'),
            document: self::getString($data, 'document'),
            cns: self::getString($data, 'cns'),
            pictureUrl: self::getString($data, 'picture_url'),
            createdAt: new DateTimeImmutable(self::getString($data, 'created_at')),
            updatedAt: new DateTimeImmutable(self::getString($data, 'updated_at')),
        );
    }
}