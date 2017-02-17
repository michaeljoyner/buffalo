<?php

namespace App\Quotes;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $table = 'quote_items';

    protected $fillable = [
        'product_id',
        'description',
        'quantity',
        'name',
        'buffalo_product_code',
        'currency',
        'factory_price',
        'supplier_name',
        'factory_number',
        'exchange_rate'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'currency' => 'string',
        'factory_price' => 'float',
        'factory_number' => 'string'
    ];
}
