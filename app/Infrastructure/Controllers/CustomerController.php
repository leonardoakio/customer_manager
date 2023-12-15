<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\Request;
use App\Application\Services\CustomerService;
use App\Application\DTO\CustomerDTO;
use App\Domain\Entities\Customer;
use App\Domain\ValueObjects\CustomerId;
use App\Infrastructure\Repositories\CustomerRepositoryInterface;

class CustomerController
{
    public function __construct(
        protected CustomerService $customerService,
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function getCustomerPanel()
    {
        try {
            $customerCollection =$this->customerService->getCustomerPanel();

            $customersDto = CustomerDTO::create($customerCollection);

            return response()->json($customersDto);
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

            return response()->json($customerData);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }

     public function createCustomer()
    {

    }

    public function updateCustomer(Request $request, string $customerId)
    {
        try {
            $customerId = CustomerId::fromString($customerId);
            $name = $request->input('name');
            $motherName = $request->input('mother_name');
            $document = $request->input('document');
            $cns = $request->input('cns');
            $picture = $request->input('picture_url');

            $customerData = Customer::fromArray([
                'id' => $customerId->asInteger(),
                'name' => $name,
                'mother_name' => $motherName,
                'document' => $document,
                'cns' => $cns,
                'picture_url' => $picture
            ]);

            $update = $this->customerRepository->updateCustomer($customerData);

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

            $this->customerRepository->deleteCustomer($customerId);

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