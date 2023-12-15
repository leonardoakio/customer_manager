<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Application\Services\CustomerService;
use App\Application\DTO\CustomerDTO;
use App\Domain\ValueObjects\CustomerId;

class CustomerController
{
    public function __construct(
        protected CustomerService $customerService,
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
            ], 404);
        }
    }
 
    public function showCustomer(string $id)
    {
        try {
            $customerId = CustomerId::fromString($id);

            $customerData = $this->customerService->getSingleCustomer($customerId);

            return response()->json($customerData);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }

     public function createCustomer(Request $request)
    {

    }

    public function updateCustomer(Request $request)
    {

    }
    
    public function deleteCustomer(Request $request)
    {
        return false;
    }
}