<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'buyer_nip' => $this->buyer_nip,
            'seller_nip' => $this->seller_nip,
            'product_name' => $this->product_name,
            'amount' => $this->amount,
            'product_price' => $this->product_price,
            'value' => $this->amount * $this->product_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
