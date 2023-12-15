<?php

namespace App\Application\DTO;

use App\Domain\Collections\CustomerCollection;

class CustomerDTO
{
    public static function create(CustomerCollection $customerCollection): array
    {
        $arrayOutput = [];

        foreach ($customerCollection->items() as $customer) {
            $arrayOutput[] = [
                'id' => $customer->getId(),
                'name' => $customer->getName(),
                'mother_name' => $customer->getMotherName(),
                'document' => $customer->getDocument()->toString(),
                'cns' => $customer->getCns()->toString(),
                'address' => $customer->getAddress()->toArray(),
                'picture_url' => $customer->getPictureUrl(),
            ];
        }

        return $arrayOutput;
    }
}