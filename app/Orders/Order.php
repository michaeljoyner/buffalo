<?php

namespace App\Orders;

use App\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'company',
        'contact_person',
        'phone',
        'fax',
        'email',
        'website',
        'referrer',
        'requirements'
    ];

    protected $dates = ['deleted_at'];

    public function getArchivedAttribute($attribute)
    {
        return $this->trashed();
    }

    public function archive()
    {
        return $this->delete();
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function addItem(Product $product, $quantity)
    {
        return $this->items()->create([
            'product_id' => $product->id,
            'name' => $product->name,
            'quantity' => $quantity
        ]);
    }
}
