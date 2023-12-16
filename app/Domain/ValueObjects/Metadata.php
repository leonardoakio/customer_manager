<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class Metadata
{
    public function __construct(
        private int $page, 
        private int $limit, 
        private int $totalRecords
    )
    {}

    private function calculateTotalPages(): int
    {
        return ceil($this->totalRecords / $this->limit);
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'limit' => $this->limit,
            'totalPages' => $this->calculateTotalPages(),
            'totalRecords' => $this->totalRecords
        ];
    }
}
