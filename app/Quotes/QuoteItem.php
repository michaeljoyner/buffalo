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
        'buffalo_product_code'
    ];
}
