<?php

namespace App\Application\Services;
use App\Infrastructure\Cache\PostalCodeCache;
use Illuminate\Support\Facades\Http;

class PostalCodeService
{
    public function __construct(
        private PostalCodeCache $cache
    ) {}

    public function searchPostalCode(string $cep)
    {
        if (!$cep) {
            return response()->json(['error' => 'CEP não fornecido'], 400);
        }

        $cep = preg_replace('/[^0-9]/', '', $cep);

        if (strlen($cep) !== 8) {
            return response()->json(['error' => 'CEP inválido'], 400);
        }

        $cepData = $this->getCepData($cep);

        if ($cepData) {
            return response()->json($cepData);
        } else {
            return response()->json(['error' => 'CEP não encontrado'], 404);
        }
    }

    public function getCepData(string $cep): ?array
    {
        $viaCepUrl = config('integration.via-cep');

        $cachedData = $this->cache->get($cep);
    
        if ($cachedData !== null) {
            return $cachedData;
        }
    
        $response = Http::get($viaCepUrl['api']['url'] . "ws/{$cep}/json");
    
        if ($response->successful()) {
            $data = $response->json();
            $this->cache->save($cep, $data, 3600);

            return $data;
        }

        return null;
    }
}