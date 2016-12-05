<?php

namespace App\Blog;

use App\Events\PostFirstPublished;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;

class Post extends Model implements HasMediaConversions
{
    use HasMediaTrait, Sluggable;

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

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
            ->setManipulations(['w' => 200, 'h' => 200, 'fit' => 'crop', 'fm' => 'src'])
            ->performOnCollections('default');
        $this->addMediaConversion('web')
            ->setManipulations(['w' => 800, 'h' => 600, 'fit' => 'max', 'fm' => 'src'])
            ->performOnCollections('default');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    public function addImage($file)
    {
        return $this->addMedia($file)->withCustomProperties(['is_feature' => false])->preservingOriginal()->toMediaLibrary();
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
