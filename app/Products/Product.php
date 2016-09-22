<?php

namespace App\Products;

use App\GetsSlugFromName;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Product extends Model implements HasMediaConversions
{
    use SoftDeletes, Sluggable, GetsSlugFromName, UrgesForDescription, HasMediaTrait, HasModelImage;

    protected $table = 'products';

    protected $fillable = [
        'product_code',
        'name',
        'description',
        'writeup',
        'original_image',
        'subcategory_id',
        'product_group_id'
    ];

    protected $casts = ['available' => 'boolean'];

    protected $dates = ['deleted_at'];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
            ->setManipulations(['w' => 200, 'h' => 200, 'fit' => 'crop'])
            ->performOnCollections('default');
        $this->addMediaConversion('web')
            ->setManipulations(['w' => 500, 'h' => 300, 'fit' => 'crop'])
            ->performOnCollections('default');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function makeAvailable($isAvailable)
    {
        $this->available = $isAvailable;
        $this->save();

        return $this->available;
    }

    public function imageSrc($conversion = "")
    {
        $modelImg = $this->modelImage($conversion);

        if($modelImg) {
            return $modelImg;
        }

        if(file_exists(public_path($this->getOriginalImage())) && $this->original_image) {
            return $this->getOriginalImage();
        }

        return '/images/buffalo_logo_small.png';
    }

    public function getOriginalImage()
    {
        $parts = explode('/', $this->original_image);
        $filename = array_pop($parts);
        return '/images/products/' . $this->category->slug . '/' . $filename;
    }
}
