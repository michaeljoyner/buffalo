<?php

namespace App\Products;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class CategoryBanner extends Model implements HasMedia
{
    use HasMediaTrait, HasModelImage;

    protected $table = 'category_banners';

    protected $fillable = [];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 300, 50)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections('default');

        $this->addMediaConversion('large')
             ->fit(Manipulations::FIT_CROP, 1400, 234)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections('default');

    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
