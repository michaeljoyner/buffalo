<?php

namespace App\Products;

use App\GetsSlugFromName;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Category extends Model implements HasMediaConversions
{
    use SoftDeletes, Sluggable, GetsSlugFromName, HasMediaTrait, UrgesForDescription, HasModelImage;

    const DEFAULT_BANNER_SRC = '/images/assets/leaves.jpg';

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description'
    ];

    protected $dates = ['deleted_at'];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
            ->setManipulations(['w' => 200, 'h' => 200, 'fit' => 'crop', 'fm' => 'src'])
            ->performOnCollections('default');
        $this->addMediaConversion('web')
            ->setManipulations(['w' => 500, 'h' => 300, 'fit' => 'crop', 'fm' => 'src'])
            ->performOnCollections('default');
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($category) {
            $category->subcategories->each(function ($sub) {
                $sub->delete();
            });

            $category->products()->whereNull('subcategory_id')->get()->each(function($product) {
                $product->delete();
            });
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function imageSrc($conversion = '')
    {
        $modelImg = $this->modelImage($conversion);

        return $modelImg ? $modelImg : '/images/buffalo_logo_small.png';
    }

    public function addProduct($attributes)
    {
        return $this->products()->create($attributes);
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }

    public function addSubcategory($attributes)
    {
        return $this->subcategories()->create($attributes);
    }

    public function bannerImage()
    {
        return $this->hasOne(CategoryBanner::class);
    }

    public function setBannerImage($file)
    {
        $banner = $this->getBanner();

        return $banner->setImage($file);
    }

    public function bannerSrc($conversion = '')
    {
        $modelImg =  $this->getBanner()->modelImage($conversion);

        return $modelImg ? $modelImg : static::DEFAULT_BANNER_SRC;
    }

    protected function getBanner()
    {
        return $this->bannerImage()->firstOrCreate([]);
    }
}
