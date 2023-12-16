<?php

namespace App\Infrastructure\Controllers;

use App\Infrastructure\Cache\PostalCodeCache;
use App\Infrastructure\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PostalCodeController extends Controller
{
    public function __construct(
        private PostalCodeCache $cache
    ) {}
    public function searchPostalCode(string $cep)
    {
        // $cep = $request->input('cep');

        if (!$cep) {
            return response()->json(['error' => 'CEP não fornecido'], 400);
        }

        // Remover caracteres não numéricos do CEP
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

    private function getCepData(string $cep): ?array
    {
        // Verificar se o CEP está no cache
        $cachedData = $this->cache->get($cep);
    
        if ($cachedData !== null) {
            return $cachedData;
        }
    
        // Se não estiver no cache, fazer a consulta na API do ViaCEP
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json");
    
        if ($response->successful()) {
            $data = $response->json();
    
            // Armazenar os dados no cache por 1 hora (3600 segundos)
            $this->cache->save($cep, $data, 3600);
    
            return $data;
        }

        return null;
    }
}
