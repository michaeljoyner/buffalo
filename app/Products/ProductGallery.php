<?php

namespace App\Products;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;

class ProductGallery extends Model implements HasMediaConversions
{
    use HasMediaTrait;

    protected $table = 'product_galleries';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 200, 200)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections('default');

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_MAX, 800, 600)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections('default');

    }
}
