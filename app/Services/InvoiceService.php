<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService
{
    public function getInvoices()
    {
        return Invoice::latest()->paginate(10);
    }
}