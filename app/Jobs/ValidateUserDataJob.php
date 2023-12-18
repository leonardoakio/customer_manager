<?php

namespace App\Jobs;

use App\Application\Services\CnsRulesService;
use App\Application\Services\CustomerService;
use App\Application\Services\PostalCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ValidateUserDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private CustomerService $customerService,
        private CnsRulesService $rulesService,
        private PostalCodeService $postalCodeService,
        private array $customerData
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $postalCode = $this->customerData['postal_code'];
        $cns = $this->customerData['cns'];

        if (isset($postalCode)) {
            $this->postalCodeService->validateCep($postalCode);
        }

        Log::info("CEP $postalCode validado com sucesso!");

        // FALTA DE MASSA DE DADOS COM CNS CORRETOS
        // if (isset($cns)) {
        //     $this->rulesService->cnsRulesValidate($cns);
        // }

        // Log::info("Número de CNS $cns é válido!");

        $savedData = $this->customerService->registerCustomer($this->customerData);

        Log::info("Customer $savedData internalizado com sucesso!");
    }
}
