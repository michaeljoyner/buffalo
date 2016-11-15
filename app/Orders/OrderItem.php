<?php

namespace App\Orders;

use App\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $table = 'order_items';

    protected $fillable = [
        'product_id',
        'name',
        'quantity'
    ];

    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
