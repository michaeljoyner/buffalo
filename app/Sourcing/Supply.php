<?php

namespace App\Sourcing;

use App\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $table = 'supplies';

    protected $fillable = [
        'quoted_date',
        'supplier_id',
        'item_number',
        'price',
        'package_price',
        'remarks'
    ];

    protected $dates = ['quoted_date'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
