<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rules\In;

class InvoiceService
{
    public function getInvoices(): LengthAwarePaginator
    {
        return Invoice::latest()->paginate(10);
    }

    public function create(array $data): void
    {
        Invoice::create($data);
    }
}