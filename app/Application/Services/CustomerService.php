<?php

namespace App\Application\Services;

use App\Domain\Collections\CustomerCollection;
use App\Domain\ValueObjects\CustomerId;
use App\Domain\ValueObjects\Pagination;
use App\Infrastructure\Repositories\AddressRepositoryInterface;
use App\Infrastructure\Repositories\CustomerRepositoryInterface;
use App\Models\Customer as CustomerModel;
use InvalidArgumentException;

class CustomerService
{
    public function __construct(
        protected CnsRulesService $cnsRulesService,
        protected PostalCodeService $postalCodeService,
        protected CustomerRepositoryInterface $customerRepository,
        protected AddressRepositoryInterface $addressRepository
    ) {}

    public function getCustomerPanel(?Pagination $pagination): array
    {
        return $this->customerRepository->getCustomersOverview($pagination);
    }

    public function getSingleCustomer(CustomerId $customerId): CustomerCollection
    {
        return $this->customerRepository->getCustomer($customerId);
    }

    public function registerCustomer(array $customerData): CustomerModel
    {
        $addressData = [
            "postal_code" => $customerData["postal_code"],
            "address" => $customerData["address"],
            "number" => $customerData["number"],
            "complement" => $customerData["complement"],
            "neighborhood" => $customerData["neighborhood"],
            "city" => $customerData["city"],
            "state" => $customerData["state"],
        ];
     
        $address = $this->addressRepository->createAddress($addressData);

        $customerDataForRepository = [
            "address_id" => $address->id,
            "name" => $customerData["name"],
            "mother_name" => $customerData["mother_name"],
            "document" => $customerData["document"],
            "cns" => $customerData["cns"],
            "picture_url" => $customerData["picture_url"],
        ];

        $customer = $this->customerRepository->createCustomer($customerDataForRepository);
    
        return $customer;
    }

    public function updateCustomerData(CustomerId $customerId, array $updateData): array
    {
        $validatedData = $this->validateDataToUpdate($updateData);
        
        if (isset($validatedData['document'])) {
            $this->validateDocument($validatedData);
        }
        
        if (isset($validatedData['cns'])) {
            $this->cnsRulesService->cnsRulesValidate($validatedData['cns']);
        }

        return $this->customerRepository->updateCustomer($customerId, $validatedData);
    }

    public function updateCustomerAddressData(int $customerId, array $updateData): array
    {
        try {
            $validatedData = $this->validateDataToUpdate($updateData);

            if (isset($validatedData['postal_code'])) {
                $data = $this->postalCodeService->validateCep($validatedData['postal_code']);

                $postalCode = $this->extractNumericPostalCode($data);

                $validatedData['postal_code'] = $postalCode;
            }

            return $this->addressRepository->updateAddress($customerId, $validatedData);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteCustomerData(CustomerId $customerId): bool
    {
        return $this->customerRepository->deleteCustomer($customerId);
    }

    public function validateDataToUpdate(array $data): array
    {
        $filteredData = array_filter($data[0], function ($value) {
            return $value !== null;
        });

        if (empty($filteredData)) {
            throw new InvalidArgumentException('Os dados a serem alterados estão vazios!');
        }

        return $filteredData; 
    }

    public function validateDocument(array $data): void
    {
        if (isset($data['document']) && strlen($data['document']) !== 11) {
            throw new InvalidArgumentException('O campo "document" deve ter 11 caracteres.');
        }
    }

    private function extractNumericPostalCode(array $data): string
    {
        return preg_replace('/[^0-9]/', '', $data['cep']);
    }
}