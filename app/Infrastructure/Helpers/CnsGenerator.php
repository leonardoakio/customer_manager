<?php

namespace App\Infrastructure\Helpers;

use App\Application\Services\CnsRulesService;

trait CnsGenerator
{
    protected $cnsRulesService;

    public function initializeCnsGenerator(CnsRulesService $cnsRulesService)
    {
        $this->cnsRulesService = $cnsRulesService;
    }
    
    public function generateRandomCnsNumbers(int $quantity = 1): array
    {
        $generatedNumbers = [];

        for ($i = 0; $i < $quantity; $i++) {
            $cns = $this->generateRandomCns();
            $generatedNumbers[] = $cns;
        }

        return $generatedNumbers;
    }

    protected function generateRandomCns(): string
    {
        $randomCns = str_pad(mt_rand(1, 999999999999999), 15, '0', STR_PAD_LEFT);

        if (!$this->cnsRulesService) {
            throw new \RuntimeException('CnsRulesService não foi inicializado.');
        }
        
        $this->cnsRulesService->cnsRulesValidate($randomCns);

        return $randomCns;
    }
}
