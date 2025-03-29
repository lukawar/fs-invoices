<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'seller_nip',
        'buyer_nip',
        'product_name',
        'product_price',
        'amount',
    ];

    public $casts = [
        'product_price' => 'float',
        'amount' => 'int',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
