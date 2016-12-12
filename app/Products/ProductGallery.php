<?php

namespace App\Products;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class ProductGallery extends Model implements HasMediaConversions
{
    use HasMediaTrait;

    protected $table = 'product_galleries';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
            ->setManipulations(['w' => 200, 'h' => 200, 'fit' => 'fill', 'fm' => 'src'])
            ->performOnCollections('default');
        $this->addMediaConversion('web')
            ->setManipulations(['w' => 800, 'h' => 600, 'fit' => 'fill', 'fm' => 'src'])
            ->performOnCollections('default');
    }
}
