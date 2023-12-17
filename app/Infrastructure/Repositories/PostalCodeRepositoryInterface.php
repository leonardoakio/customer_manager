<?php

namespace App\Infrastructure\Repositories;

interface PostalCodeRepositoryInterface
{
    public function getPostalCodeData(string $postalCode): array;
}