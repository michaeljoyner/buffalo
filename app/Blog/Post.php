<?php

namespace App\Blog;

use App\Events\PostFirstPublished;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia, Sluggable;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'description',
        'body',
        'published',
        'published_at'
    ];

    protected $defaultTitleImages = [
        '/images/news/default/news_default_1.jpg',
        '/images/news/default/news_default_2.jpg'
    ];

    protected $casts = ['published' => 'boolean'];

    protected $dates = ['published_at'];

    public function registerMediaConversions(Media $media = null): void
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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    public function addImage($file)
    {
        return $this->addMedia($file)->withCustomProperties(['is_feature' => false])->preservingOriginal()->toMediaCollection();
    }

    public function getImages()
    {
        return $this->getMedia();
    }

    public function setFeaturedImage(Media $image)
    {
        if($this->doesNotOwnImage($image)) {
            throw new \Exception('Image must belong to post to be set as featured.');
        }

        $this->resetPreviousFeaturedToFalse();

        $image->setCustomProperty('is_feature', true);
        $image->save();
    }

    protected function doesNotOwnImage($image)
    {
        return ($image->model_type !== static::class) || (intval($image->model_id) !== $this->id);
    }

    protected function resetPreviousFeaturedToFalse()
    {
        $this->getMedia()->filter(function($media) {
            return $media->getCustomProperty('is_feature');
        })->each(function($media) {
            $media->setCustomProperty('is_feature', false);
            $media->save();
        });
    }

    public function featuredImage()
    {
        return $this->getMedia()->first(function($media) {
            return $media->getCustomProperty('is_feature');
        });
    }

    public function titleImg($conversion = '')
    {
        $featured = $this->featuredImage();

        $titleImg = $featured ? $featured->getUrl($conversion) : $this->getFirstMediaUrl('default', $conversion);

        return $titleImg ?: collect($this->defaultTitleImages)->random();
    }


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setPublishedStatus($shouldPublish)
    {
        if($this->beingPublishedForFirstTime($shouldPublish)) {
            $this->published_at = Carbon::now();
            event(new PostFirstPublished($this));
        }
        $this->published = $shouldPublish;
        return $this->save();
    }

    protected function beingPublishedForFirstTime($toBePublished)
    {
        return $toBePublished && is_null($this->published_at);
    }


}
