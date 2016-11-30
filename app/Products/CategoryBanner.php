<?php

namespace App\Products;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class CategoryBanner extends Model implements HasMediaConversions
{
    use HasMediaTrait, HasModelImage;

    protected $table = 'category_banners';

    protected $fillable = [];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
            ->setManipulations(['w' => 300, 'h' => 50, 'fit' => 'crop'])
            ->performOnCollections('default');
        $this->addMediaConversion('large')
            ->setManipulations(['w' => 1400, 'h' => 234, 'fit' => 'crop'])
            ->performOnCollections('default');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
