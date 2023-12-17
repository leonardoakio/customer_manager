<?php

namespace App\Application\Services;

use App\Infrastructure\Cache\PostalCodeCache;
use App\Infrastructure\Repositories\PostalCodeRepositoryInterface;
use InvalidArgumentException;

class PostalCodeService
{
    public function __construct(
        private PostalCodeCache $cache,
        private PostalCodeRepositoryInterface $postalCodeRepository
    ) {}

    public function validateCep(string $postalCode)
    {
        if (!$postalCode) {
            return response()->json(['error' => 'CEP não fornecido'], 400);
        }

        $postalCode = preg_replace('/[^0-9]/', '', $postalCode);

        if (strlen($postalCode) !== 8) {
            return response()->json(['error' => 'CEP inválido'], 400);
        }

        return $this->getCepData($postalCode);
    }

    public function getCepData(string $postalCode): ?array
    {
        $cachedData = $this->cache->get($postalCode);
    
        if ($cachedData !== null) {
            return $cachedData;
        }

        $response = $this->postalCodeRepository->getPostalCodeData($postalCode);
    
        if (!$response) {
            throw new InvalidArgumentException('O CEP não pode ser consultado!');
        }

        $this->cache->save($postalCode, $response, 3600);

        return $response;
    }
}