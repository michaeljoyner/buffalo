<?php

namespace App\Quotes;

use Hemp\Presenter\Presentable;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use Presentable;

    const LESS_THAN_HALF_COMPLETE = 1;
    const LESS_THAN_ALMOST_COMPLETE = 2;
    const ALMOST_COMPLETE = 3;
    const FULLY_COMPLETE = 4;

    protected $table = 'quote_items';

    protected $fillable = [
        'product_id',
        'description',
        'quantity',
        'name',
        'remark',
        'buffalo_product_code',
        'currency',
        'factory_price',
        'additional_cost',
        'additional_cost_memo',
        'supplier_name',
        'factory_number',
        'package_price',
        'exchange_rate',
        'profit',
        'moq',
        'package_type',
        'package_unit',
        'package_inner',
        'package_outer',
        'package_carton',
        'net_weight',
        'gross_weight'
    ];

    protected $casts = [
        'quantity'       => 'integer',
        'currency'       => 'string',
        'factory_price'  => 'float',
        'factory_number' => 'string'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $quote = $item->quote->fresh();
            if($quote && $quote->isFinal()) {
                return false;
            }
            return true;
        });
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }

    public function withProductData($product)
    {
        $this->update([
            'product_id'           => $product->id,
            'name'                 => $product->name,
            'description'          => $product->writeup,
            'buffalo_product_code' => $product->product_code,
            'moq'                  => $product->minimum_order_quantity,
        ]);

        return $this;
    }

    public function withPackagingData($packaging)
    {
        $this->update([
            'package_type'   => $packaging->type,
            'package_unit'   => $packaging->unit,
            'package_inner'  => $packaging->inner,
            'package_outer'  => $packaging->outer,
            'package_carton' => $packaging->carton,
            'net_weight'     => $packaging->net_weight,
            'gross_weight'   => $packaging->gross_weight
        ]);

        return $this;
    }

    public function withSupplyData($supply)
    {
        $this->update([
            'supplier_name'  => $supply->supplier->name ?? null,
            'factory_number' => $supply->item_number,
            'currency'       => $supply->currency,
            'factory_price'  => $supply->price,
            'package_price'  => $supply->package_price
        ]);

        return $this;
    }

    public function completeness()
    {
        $incomplete = collect($this->fillable)->filter(function ($attribute) {
            return $this->{$attribute} === null || $this->{$attribute} === '';
        })->count();
        $completenessPercentage = 100 - (($incomplete / 24) * 100);

        if ($completenessPercentage < 50) {
            return static::LESS_THAN_HALF_COMPLETE;
        } else {
            if ($completenessPercentage >= 50 && $completenessPercentage < 90) {
                return static::LESS_THAN_ALMOST_COMPLETE;
            } else {
                if ($completenessPercentage >= 90 && $completenessPercentage < 100) {
                    return static::ALMOST_COMPLETE;
                } else {
                    if ($completenessPercentage === 100) {
                        return static::FULLY_COMPLETE;
                    }
                }
            }
        }
    }

    public function setComputedPrices()
    {
        $factory = $this->factory_price ?: 0;
        $package = $this->package_price ?: 0;
        $additional = $this->additional_cost ?: 0;
        $exchange = $this->exchange_rate ?: 1;
        $profit = $this->profit ?: 1;

        $cost = round($factory + $package + $additional, 2);
        $sales = round(($cost / $exchange) / $profit, 2);

        $this->total_cost = $cost;
        $this->selling_price = $sales;
        $this->save();
    }
}
