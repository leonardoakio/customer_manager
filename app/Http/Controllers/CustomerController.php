<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CustomerController
{
    public function getCustomerPanel(Request $request)
    {
        $userId = UserId::fromString($request->header('user_id'));

        $customerPlans =$this->customerPlansRepository->getCustomerPlans($userId);

        return $this->response->json($customerPlans);
    }

    public function showCustomer(Request $request)
    {
        $userId = UserId::fromString($request->header('user_id'));

        $customerPlans =$this->customerPlansRepository->getCustomerPlans($userId);

        return $this->response->json($customerPlans);
    }

     public function createCustomer(Request $request)
    {
        try {
            $userId = (int)$request->header('user_id');
            $planName = $request->input('name');
            $planValue = $request->input('value');

            $now = new DateTimeImmutable();

            $customerPlan = CustomerPlan::fromArray([
                'user_id' => $userId,
                'name' => $planName,
                'status' => CustomerPlanStatusEnum::ACTIVE,
                'value' => $planValue,
                'active_at' => $now->format('Y-m-d H:i:s')
            ]);

            $this->customerPlansRepository->saveCustomerPlan($customerPlan);

            return $this->response->json([
                'message' => 'Sucesso ao incluir os dados!',
                'data' => $customerPlan->toArray()
            ]);
        } catch (\Throwable $e) {
            return $this->response->json([
                'message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    public function updateCustomer(Request $request)
    {
        $userId = UserId::fromString($request->header('user_id'))->asInteger();
        $id = $request->input('id');
        $planName = $request->input('name');
        $status = $request->input('status');
        $value = $request->input('value');

        $customerPlan = CustomerPlan::fromArray([
            'id' => $id,
            'user_id' => $userId,
            'name' => $planName,
            'status' => $status ?: CustomerPlanStatusEnum::ACTIVE,
            'value' => $value
        ]);

        $update = $this->customerPlansRepository->updateCustomerPlan($customerPlan);

        $updatedData = array_merge(['id' => $id, 'user_id' => $userId,], $update);

        return $this->response->json([
            'message' => 'Sucesso ao atualizar os dados!',
            'data' => $updatedData
        ]);
    }
    
    public function deleteCustomer(Request $request)
    {
        return false;
    }
}