<?php

namespace App\Quotes;

use App\Customers\Customer;
use App\Products\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quote extends Model
{
    protected $table = 'quotes';

    protected $fillable = [
        'quote_number',
        'customer_id',
        'order_id',
        'valid_until',
        'payment_terms',
        'terms',
        'remarks',
        'quotation_remarks',
        'shipment',
        'base_profit',
        'base_exchange_rate'
    ];

    protected $dates = ['valid_until'];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($quote) {
            $quote->items->each(function ($item) {
                $item->delete();
            });
        });

        static::creating(function ($quote) {
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
        $product = Product::find($orderItem->product_id);

        if ($product) {
            $item = $this->addItem($product, $orderItem->quantity);
            $item->name = $orderItem->name;
            $item->save();

            return $item;
        }

        return $this->items()->create([
            'product_id'           => $orderItem->product_id,
            'quantity'             => $orderItem->quantity,
            'description'          => null,
            'name'                 => $orderItem->name,
            'buffalo_product_code' => null
        ]);
    }

    public function addItem($product, $quantity = null, $supply = null)
    {
        if($this->itemHasAlreadyBeenAddedForProduct($product)) {
            return;
        }
        
        $packaging = $product->getPackaging();
        $supply = $supply ?: $product->getBestSupply();

        return $this->items()->create([
            'product_id'    => $product->id,
            'exchange_rate' => $this->base_exchange_rate,
            'profit'        => $this->base_profit,
            'quantity'      => $quantity ?: $product->minimum_order_quantity,
        ])->withProductData($product)
            ->withPackagingData($packaging)
            ->withSupplyData($supply);
    }

    protected function itemHasAlreadyBeenAddedForProduct($product)
    {
        return QuoteItem::where('product_id', $product->id)->where('quote_id', $this->id)->count() > 0;
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
