<?php

namespace App\Infrastructure\Repositories;

use GuzzleHttp\Client;
use InvalidArgumentException;

class PostalCodeRepository implements PostalCodeRepositoryInterface
{
    public function __construct(
    ) {}

    public function getPostalCodeData(string $postalCode): array
    {
        $viaCepUrl = config('integration.via-cep');
        
        $client = new Client();
        
        $response = $client->get($viaCepUrl['api']['url'] . "ws/{$postalCode}/json");

        $body = $response->getBody()->getContents();

        return json_decode($body, true);
    }
}