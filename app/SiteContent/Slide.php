<?php

namespace App\SiteContent;

use App\Products\HasModelImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Slide extends Model implements HasMedia
{
    use HasMediaTrait, HasModelImage;

    const DEFAULT_SLIDE_TEXT = '';

    protected $table = 'slides';

    protected $fillable = [
        'is_video',
        'video',
        'slide_text',
        'action_text',
        'action_link',
        'text_colour'
    ];

    protected $casts = ['is_video' => 'boolean', 'is_published' => 'boolean'];

    public static function boot()
    {
        parent::boot();

        static::deleted(function($slide) {
            if($slide->video && file_exists(public_path('videos/' . $slide->video))) {
                $slide->unlinkVideo($slide->video);
            }
        });

        return true;
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('small')
             ->fit(Manipulations::FIT_CROP, 500, 500)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections('default');

        $this->addMediaConversion('phone')
             ->fit(Manipulations::FIT_CROP, 720, 432)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections('default');

        $this->addMediaConversion('large')
             ->fit(Manipulations::FIT_CROP, 1400, 467)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections('default');
    }

    public static function createDefault()
    {
        return static::create([
            'slide_text'  => static::DEFAULT_SLIDE_TEXT,
            'action_text' => '',
            'action_link' => ''
        ]);
    }

    public function isComplete()
    {
        return $this->getMedia()->count() > 0 || ($this->is_video && $this->video);
    }

    public function publish()
    {
        return $this->setPublishedState(true);
    }

    public function unpublish()
    {
        return $this->setPublishedState(false);
    }

    protected function setPublishedState($publish)
    {
        $this->is_published = $publish;
        $this->save();

        return $this->is_published;
    }

    public function putImage($image)
    {
        $new_image = $this->setImage($image);
        $this->is_video = false;
        $this->save();

        return $new_image;
    }

    public function setVideo(UploadedFile $video)
    {
        $existing = $this->video;

        $path = $video->store('banners', 'banners');
        $this->video = $path;
        $this->is_video = true;
        $this->save();

        $this->fresh();

        if($existing && $existing !== $this->video) {
            $this->unlinkVideo($existing);
        }

        return $this->video;
    }

    protected function unlinkVideo($slideVideoPath)
    {
        unlink(public_path('videos/' . $slideVideoPath));
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    public static function inOrder()
    {
        $withOrder = static::whereNotNull('position')->ordered()->get();
        $withoutOrder = static::whereNull('position')->get();

        return $withOrder->merge($withoutOrder);
    }

    public static function setOrder($ordered_ids)
    {
        collect($ordered_ids)->each(function($slide_id, $position) {
            $slide = static::findOrFail($slide_id);
            $slide->position = $position + 1;
            $slide->save();
        });

        static::whereNotIn('id', $ordered_ids)->get()->each(function($unordered_slide) {
            $unordered_slide->position = null;
            $unordered_slide->save();
        });
    }
}
