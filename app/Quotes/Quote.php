<?php

namespace App\Quotes;

use App\Customers\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quote extends Model
{
    protected $table = 'quotes';

    protected $fillable = ['customer_id', 'order_id', 'valid_until', 'payment_terms', 'remarks'];

    protected $dates = ['valid_until'];

    public static function boot()
    {
        parent::boot();

        static::deleted(function($quote) {
           $quote->items->each(function($item) {
               $item->delete();
           });
        });

        static::creating(function($quote) {
            $prefix = strtoupper(str_random(3));
            $timestring = Carbon::now()->format('Ymd');
            $quote->quote_number = $prefix . '_' . $timestring;
        });
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class, 'quote_id');
    }

    public function addItemFromOrder($orderItem)
    {
        return $this->items()->create([
            'product_id' => $orderItem->product_id,
            'quantity' => $orderItem->quantity,
            'description' => $orderItem->product->description ?? null,
            'name' => $orderItem->name,
            'buffalo_product_code' => $orderItem->product->product_code ?? null
        ]);
    }

    public function isFinal()
    {
        return $this->finalized_on !== null;
    }

    public function finalize()
    {
        $this->finalized_on = Carbon::now();
        $this->save();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }


}
