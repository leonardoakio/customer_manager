<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class Pagination
{
    public function __construct(
        private ?int $page = 1,
        private ?int $limit = 20,
        private ?OrderBy $orderBy,
        private ?int $offset = null,
        private ?int $totalRecords = null,
        private ?int $returnedRecords = null
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (!is_null($this->offset) && $this->offset < 0) {
            throw new InvalidArgumentException(
                "O 'offset' deve ser maior que 0."
            );
        }

        if (!is_null($this->limit) && $this->limit < 0) {
            throw new InvalidArgumentException(
                "O 'limit' deve ser maior que 0."
            );
        }
    }

    public function page(): ?int
    {
        return $this->page;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public function orderBy(): ?OrderBy
    {
        return $this->orderBy;
    }

    public function setTotalRecords($totalRecords): ?int
    {
        return $this->totalRecords = $totalRecords;
    }

    public function totalRecords(): ?int
    {
        return $this->totalRecords;
    }

    public function returnedRecords(): ?int
    {
        return $this->returnedRecords;
    }

    public function getTotalPages(): int
    {
        return ceil($this->totalRecords / $this->limit);
    }

    public function toArray(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
            'orderBy' => $this->orderBy?->asString(),
            'totalRecords' => $this->totalRecords,
            'returnedRecords' => $this->returnedRecords
        ];
    }
}
