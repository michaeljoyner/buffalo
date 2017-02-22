<?php

namespace App\Products;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    protected $table = 'packaging';

    protected $fillable = [
        'type',
        'unit',
        'inner',
        'outer',
        'carton',
        'net_weight',
        'gross_weight'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getNetWeightKgsAttribute()
    {
        return number_format($this->net_weight, 2) . 'kg';
    }

    public function getGrossWeightKgsAttribute()
    {
        return number_format($this->gross_weight, 2) . 'kg';
    }
}
