<?php

namespace App\Products;

use App\GetsSlugFromName;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use SoftDeletes, Sluggable, UrgesForDescription;

    protected $table = 'subcategories';

    protected $fillable = [
        'name',
        'description'
    ];

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::deleted(function($subcategory) {
            $subcategory->productGroups->each(function($group) {
                $group->delete();
            });

            $subcategory->products()->whereNull('product_group_id')->get()->each(function($product) {
                $product->delete();
            });
        });
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function productGroups()
    {
        return $this->hasMany(ProductGroup::class, 'subcategory_id');
    }

    public function addProductGroup($attributes)
    {
        return $this->productGroups()->create($attributes);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }

    public function addProduct($attributes)
    {
        return $this->category->addProduct(array_merge(['subcategory_id' => $this->id], $attributes));
    }
}
