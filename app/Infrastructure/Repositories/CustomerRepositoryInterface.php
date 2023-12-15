<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Collections\CustomerCollection;


interface CustomerRepositoryInterface
{
    public function getCustomersOverview(): CustomerCollection;
}