<?php

namespace App\Jobs;

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
        private PostalCodeService $postalCodeService,
        private string $cep
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Executing ValidateData job');

        $this->postalCodeService->searchPostalCode($this->cep);
    }
}
