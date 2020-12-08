<?php

namespace App\Products;

use App\GetsSlugFromName;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
{
    use SoftDeletes, Sluggable, InteractsWithMedia, UrgesForDescription, HasModelImage;

    const DEFAULT_BANNER_SRC = '/images/assets/leaves.jpg';

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description'
    ];

    protected $dates = ['deleted_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 200, 200)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections('default');

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_CROP, 500, 300)
             ->keepOriginalImageFormat()
             ->optimize()
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
        $hasSameCode = Product::withTrashed()->where('product_code', $attributes['product_code'])->get();
        $counter = 1;

        while($hasSameCode->count() > 0) {
            $hasSameCode->each(function($product) use ($counter) {
                $product->product_code = $product->product_code . '_' . $counter;
                $product->save();
                $counter = $counter + 1;
            });
            $hasSameCode = Product::withTrashed()->where('product_code', $attributes['product_code'])->get();
        }
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

    public static function setOrder(array $order)
    {
        static::whereNotIn('id', $order)->get()->each(function($cat) {
            $cat->position = null;
            $cat->save();
        });

        collect($order)->each(function($id, $zeroedPosition) {
            $category = static::findOrFail($id);
            $category->position = $zeroedPosition + 1;
            $category->save();
        });
    }

    public static function getOrdered()
    {
        return static::orderBy('position')->get()->values();
    }

}
