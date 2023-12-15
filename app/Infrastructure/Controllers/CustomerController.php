<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\Request;
use App\Application\Services\CustomerService;
use App\Application\DTO\CustomerDTO;
use App\Domain\Entities\Customer;
use App\Domain\ValueObjects\CustomerId;
use App\Domain\ValueObjects\OrderBy;
use App\Domain\ValueObjects\Pagination;
use App\Infrastructure\Repositories\CustomerRepositoryInterface;

class CustomerController
{
    public function __construct(
        protected CustomerService $customerService,
        protected CustomerRepositoryInterface $customerRepository
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