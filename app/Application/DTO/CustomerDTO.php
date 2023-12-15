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
                'document' => $customer->getDocument(),
                'cns' => $customer->getCns(),
                'picture_url' => $customer->getPictureUrl(),
            ];
        }

        return $arrayOutput;
    }
}