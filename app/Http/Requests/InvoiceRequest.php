<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number' => 'required|string',
            'buyer_nip' => 'required|string',
            'seller_nip' => 'required|string',
            'product_name' => 'required|string',
            'amount' => 'required|integer',
            'product_price' => 'required|numeric',
        ];
    }
}
