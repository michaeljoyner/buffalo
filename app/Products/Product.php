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

    const DEFAULT_PRIMARY_IMAGE = '/images/buffalo_logo_small.png';

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

    protected $casts = ['available' => 'boolean', 'is_promoted' => 'boolean'];

    protected $dates = ['deleted_at'];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
            ->setManipulations(['w' => 200, 'h' => 200, 'fit' => 'crop', 'fm' => 'src'])
            ->performOnCollections('default');
        $this->addMediaConversion('web')
            ->setManipulations(['w' => 800, 'h' => 600, 'fit' => 'crop', 'fm' => 'src'])
            ->performOnCollections('default');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id');
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

        return static::DEFAULT_PRIMARY_IMAGE;
    }

    public function getOriginalImage()
    {
        $parts = explode('/', $this->original_image);
        $filename = array_pop($parts);
        return '/images/products/' . $this->category->slug . '/' . $filename;
    }

    public function gallery()
    {
        return $this->hasOne(ProductGallery::class);
    }

    public function getGallery()
    {
        return $this->gallery()->firstOrCreate([]);
    }

    public function galleryImages()
    {
        return $this->getGallery()->getMedia();
    }

    public function addGalleryImage($image)
    {
        return $this->getGallery()->addMedia($image)->preservingOriginal()->toMediaLibrary();
    }

    public function allImageUrls($conversion = '')
    {
        return collect([])->push($this->imageSrc($conversion))
            ->merge($this->galleryImages()->map(function($image) use ($conversion) {
            return $image->getUrl($conversion);
        })->toArray());
    }

    public function promote()
    {
        return $this->setPromotedStatus(true);
    }

    public function demote()
    {
        return $this->setPromotedStatus(false);
    }

    protected function setPromotedStatus($shouldPromote)
    {
        $this->is_promoted = $shouldPromote;
        $this->save();

        return $this->is_promoted;
    }
}
