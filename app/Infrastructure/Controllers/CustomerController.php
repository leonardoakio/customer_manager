<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Domain\ValueObject\CustomerId;
use App\Application\Services\CustomerService;
use App\Application\DTO\CustomerDTO;

class CustomerController
{
    public function __construct(
        protected CustomerService $customerService,
    ) {}

    public function getCustomerPanel(Request $request)
    {
        $customerCollection =$this->customerService->getCustomerPanel();

        $customersDto = CustomerDTO::create($customerCollection);

        return response()->json($customersDto);
    }
 
    public function showCustomer(Request $request)
    {

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