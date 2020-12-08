<?php

namespace App\Products;

use App\GetsSlugFromName;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGroup extends Model
{
    use SoftDeletes, Sluggable, UrgesForDescription;

    protected $table = 'product_groups';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::deleted(function($group) {
            $group->products->each(function($product) {
                $product->delete();
            });
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function addProduct($attributes)
    {
        return $this->subcategory->category->addProduct(array_merge([
            'subcategory_id' => $this->subcategory->id,
            'product_group_id' => $this->id
        ], $attributes));
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_group_id');
    }
}
