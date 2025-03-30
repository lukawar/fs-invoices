<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceCollection;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(public InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Invoices', [
            'invoices' => InvoiceResource::collection($this->invoiceService->getInvoices()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(InvoiceRequest $request)
    {
        $this->invoiceService->create($request->validated());
    
        return redirect()->route('invoices.index')->with('success', 'Nowa faktura została wystawiona.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest  $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return redirect()->route('invoices.index')->with('success', 'Faktura została zaktualizowana.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Faktura została usunięta.');
    }

}
