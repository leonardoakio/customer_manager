<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\Request;
use App\Application\Services\CnsRulesService;
use App\Application\Services\PostalCodeService;
use App\Infrastructure\Controllers\Controller;

class ValidationDataController extends Controller
{
    public function __construct(
        private PostalCodeService $postalCodeService,
        private CnsRulesService $cnsRulesService
    ) {}
    public function validatePostalCode(Request $request)
    {
        try {
            $postalCode = $request->input('postal_code');

            $data = $this->postalCodeService->validateCep($postalCode);
    
            return response()->json($data);
        } catch (\Exception $e) {
            $response = $e->getResponse();

            return response()->json([
                'message' => 'Erro ao consultar cep no via_cep',
                'data' => [
                    'error_code' => $response->getStatusCode(),
                    'reason' => $response->getReasonPhrase(),
                    'response' => $response->getBody()->getContents()
                ]
            ]);
        }
    }

    public function validateCns(Request $request)
    {
        try {
            $cns = $request->input('cns');

            $this->cnsRulesService->cnsRulesValidate($cns);

            return response()->json([
                'message' => sprintf('O número de CNS %s e o status é válido', $cns)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
