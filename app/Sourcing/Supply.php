<?php

namespace App\Sourcing;

use App\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $table = 'supplies';

    protected $fillable = [
        'quoted_date',
        'valid_until',
        'supplier_id',
        'item_number',
        'currency',
        'price',
        'package_price',
        'remarks'
    ];

    protected $dates = ['quoted_date', 'valid_until'];

    protected $casts = [
        'item_number' => 'string',
        'price' => 'float',
        'package_price' => 'float'
    ];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
