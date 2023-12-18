<?php

namespace App\Infrastructure\Controllers;

use App\Application\Services\PostalCodeService;
use App\Infrastructure\Repositories\AddressRepositoryInterface;
use App\Jobs\ValidateUserDataJob;
use Illuminate\Http\Request;
use App\Application\Services\CustomerService;
use App\Application\DTO\CustomerDTO;
use App\Domain\ValueObjects\CustomerId;
use App\Domain\ValueObjects\OrderBy;
use App\Domain\ValueObjects\Pagination;
use App\Infrastructure\Repositories\CustomerRepositoryInterface;

class CustomerController
{
    public function __construct(
        private PostalCodeService $postalCodeService,
        protected CustomerService $customerService,
        protected CustomerRepositoryInterface $customerRepository,
        protected AddressRepositoryInterface $addressRepository
    ) {}

    public function getCustomerPanel(Request $request)
    {
        try {
            $page = $request->has('page') ? (int)$request->query('page') : null;
            $limit = $request->has('limit') ? (int)$request->query('limit') : null;
            $orderBy = $request->has('orderby') ? (string)$request->query('orderby') : 'asc';
            
            $pagination = new Pagination(
                page: $page,
                limit: $limit,
                orderBy: new OrderBy($orderBy)
            );

            $customerData =$this->customerService->getCustomerPanel($pagination);

            $customersDto = CustomerDTO::create($customerData['customers']);

            return response()->json([
                'customers' => $customersDto,
                'metadata' => $customerData['metadata'],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'archive' => $e->getFile(),
                'line' => $e->getLine()
            ], 404); 
        }
    }
 
    public function showCustomer(string $customerId)
    {
        try {
            $customerId = CustomerId::fromString($customerId);

            $customerData = $this->customerService->getSingleCustomer($customerId);

            $customersDto = CustomerDTO::create($customerData);

            return response()->json($customersDto[0]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function createCustomer(Request $request)
    {
        $cep = $request->input('cep');

        // putenv("REDIS_QUEUE=cep_validation");
    
        ValidateUserDataJob::dispatch($this->postalCodeService, $cep)->onQueue('data_sync');
        
        return response()->json([
            'message' => 'Usuário adicionado com sucesso.'
        ]);
    }

    public function updateCustomer(Request $request, string $customerId)
    {
        try {
            $customerId = CustomerId::fromString($customerId);
            $updateData = $request->input('data');

            $update = $this->customerService->updateCustomerData($customerId, $updateData);

            return response()->json([
                'message' => 'Sucesso ao atualizar os dados!',
                'data' => $update
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function updateCustomerAddress(Request $request, string $customerId)
    {
        try {
            $customerId = CustomerId::fromString($customerId)->asInteger();
            $updateData = $request->input('data');

            $update = $this->customerService->updateCustomerAddressData($customerId, $updateData);

            return response()->json([
                'message' => 'Sucesso ao atualizar os dados!',
                'data' => $update
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }
    
    public function deleteCustomer(string $customerId)
    {
        try {
            $customerId = CustomerId::fromString($customerId);

            $this->customerService->deleteCustomerData($customerId);

            return response()->json([
                'message' => 'Sucesso ao deletar o customer!'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }
}