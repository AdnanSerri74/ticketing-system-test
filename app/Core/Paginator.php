<?php

namespace app\Core;

class Paginator
{
    protected int $perPage;

    protected int $currentPage;

    protected int $totalRows;

    protected int $totalPages;

    protected mixed $paginatedData;

    public function __construct(int $perPage, int $currentPage, int $totalRows, int $totalPages, mixed $paginatedData)
    {
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->totalRows = $totalRows;
        $this->totalPages = $totalPages;
        $this->paginatedData = $paginatedData;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function totalRows(): int
    {
        return $this->totalRows;
    }

    public function totalPages(): int
    {
        return $this->totalPages;
    }

    public function data(): mixed
    {
        return $this->paginatedData;
    }

    public function hasNext(): bool
    {
        return $this->currentPage < $this->totalPages;
    }

    public function next(): string
    {
        if (!$this->hasNext())
            return '?page=' . ($this->currentPage);
        return '?page=' . ($this->currentPage + 1);
    }

    public function hasPrevious(): bool
    {
        return $this->currentPage > 1;
    }

    public function previous(): string
    {
        if (!$this->hasPrevious())
            return '?page=' . ($this->currentPage);

        return '?page=' . ($this->currentPage - 1);
    }

    public function last(): string
    {
        return '?page=' . ($this->totalPages);
    }

    public function first(): string
    {
        return '?page=1';
    }

    public function getPage(int $page)
    {
        return '?page=' . $page;
    }

    public function getPaginationInfo(): array
    {
        return [
            'perPage' => $this->perPage(),
            'currentPage' => $this->currentPage(),
            'totalRows' => $this->totalRows(),
            'totalPages' => $this->totalPages
        ];
    }
}