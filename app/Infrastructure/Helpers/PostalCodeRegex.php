<?php

namespace App\Infrastructure\Helpers;

trait PostalCodeRegex
{
    public function extractNumericPostalCode(string $postalCode)
    {
        return preg_replace('/[^0-9]/', '', $postalCode);
    }
}
