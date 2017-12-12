<?php

namespace App\Products;

use App\GetsSlugFromName;
use App\Sourcing\Supply;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;

class Product extends Model implements HasMediaConversions
{
    use SoftDeletes, Sluggable, UrgesForDescription, HasMediaTrait, HasModelImage;

    const DEFAULT_PRIMARY_IMAGE = '/images/buffalo_logo_small.png';
    const DAYS_TO_BE_NEW = 90;

    protected $table = 'products';

    protected $fillable = [
        'product_code',
        'name',
        'description',
        'writeup',
        'original_image',
        'subcategory_id',
        'product_group_id',
        'minimum_order_quantity'
    ];

    protected $casts = ['available' => 'boolean', 'is_promoted' => 'boolean', 'marked_new' => 'boolean'];

    protected $dates = ['deleted_at', 'new_until', 'promoted_until'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getMinimumOrderQuantityAttribute($moq)
    {
        return $moq ?? 500;
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_FILL, 200, 200)
            ->background('ffffff')
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections('default');

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_MAX, 800, 600)
             ->keepOriginalImageFormat()
             ->optimize()
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

        if ($modelImg) {
            return $modelImg;
        }

        if (file_exists(public_path($this->getOriginalImage())) && $this->original_image) {
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
        return $this->getGallery()->addMedia($image)->preservingOriginal()->toMediaCollection();
    }

    public function allImageUrls($conversion = '')
    {
        return collect([])->push($this->imageSrc($conversion))
            ->merge($this->galleryImages()->map(function ($image) use ($conversion) {
                return $image->getUrl($conversion);
            })->toArray());
    }

    public function isPromoted()
    {
        return !is_null($this->promoted_until) && $this->promoted_until->gte(Carbon::now());
    }

    public function promote($promote_until)
    {
        $this->promoted_until = $promote_until;
        $this->save();

        return $this->isPromoted();
    }

    public function demote()
    {
        $this->promoted_until = null;
        $this->save();

        return $this->isPromoted();
    }

    protected function setPromotedStatus($shouldPromote)
    {
        $this->is_promoted = $shouldPromote;
        $this->save();

        return $this->is_promoted;
    }

    public function moveToCategory($categoryId)
    {
        $newCategory = Category::findOrFail($categoryId);

        $this->subcategory_id = null;
        $this->product_group_id = null;
        $this->category_id = $newCategory->id;

        return $this->save();
    }

    public function moveToSubcategory($subcategoryId)
    {
        $newSubcategory = Subcategory::findOrFail($subcategoryId);

        $this->category_id = $newSubcategory->category_id;
        $this->subcategory_id = $newSubcategory->id;
        $this->product_group_id = null;

        return $this->save();
    }

    public function moveToProductGroup($productGroupId)
    {
        $newProductGroup = ProductGroup::findOrFail($productGroupId);

        $this->category_id = $newProductGroup->subcategory->category->id;
        $this->subcategory_id = $newProductGroup->subcategory->id;
        $this->product_group_id = $newProductGroup->id;

        return $this->save();
    }

    public function isNew()
    {
        return $this->marked_new;
    }

    public function markAsNew($is_new, $days_to_be_new = null)
    {
        if(is_null($days_to_be_new)) {
            $days_to_be_new = static::DAYS_TO_BE_NEW;
        }

        $is_new ? $this->touchNewUntilDate($days_to_be_new) : $this->clearNewUntilDate();
        $this->marked_new = $is_new;
        $this->save();

        return $this->marked_new;
    }

    protected function touchNewUntilDate($days_to_be_new)
    {
        $this->new_until = Carbon::now()->addDays($days_to_be_new);
    }

    protected function clearNewUntilDate()
    {
        $this->new_until = null;
    }

    public function daysStillNew()
    {
        if($this->new_until) {
            return $this->new_until->diffInDays(Carbon::now());
        }

        return null;
    }

    public function note()
    {
        return $this->hasOne(ProductNote::class);
    }

    public function setNote($content, $user)
    {
        if ($this->note && ($this->note->content !== $content)) {
            $this->note->update([
                'user_id' => $user->id,
                'content' => $content
            ]);

            return $this->note;
        }

        return $this->note ?? $this->note()->create([
            'user_id' => $user->id,
            'content' => $content
        ]);
    }

    public function clearNote()
    {
        if ($this->note) {
            $this->note->delete();
        }
    }

    public function getNote()
    {
        return $this->note ? $this->note->content : '';
    }

    public function supplies()
    {
        return $this->hasMany(Supply::class, 'product_id');
    }

    public function addSupply($data)
    {
        return $this->supplies()->create($data);
    }

    public function getBestSupply()
    {
        $latest = $this->supplies()->latest()->first();

        return $latest ?: new Supply();
    }

    public function packaging()
    {
        return $this->hasMany(Packaging::class, 'product_id');
    }

    public function addPackaging($packagingData)
    {
        return $this->packaging()->create($packagingData);
    }

    public function getPackaging()
    {
        $package = $this->packaging()->latest()->first();

        return $package ?? new Packaging();
    }
}
