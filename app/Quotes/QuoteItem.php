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
        'quantity' => 'integer',
        'currency' => 'string',
        'factory_price' => 'float',
        'factory_number' => 'string'
    ];

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
}
