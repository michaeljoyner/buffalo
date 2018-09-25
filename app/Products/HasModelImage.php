<?php
/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/2/16
 * Time: 11:05 AM
 */

namespace App\Products;


trait HasModelImage
{
    public function modelImage($conversion = '')
    {
        return $this->getFirstMediaUrl('default', $conversion);
    }

    public function setImage($image)
    {

        $newImage = $this->addMedia($image)->preservingOriginal()->toMediaCollection('default');

        $this->removeOlderImages();

        return $newImage;
    }

    protected function removeOlderImages()
    {
        $this->getMedia('default')->reverse()->slice(1)->each(function($media) {
            $media->delete();
        });
    }

    public function hasModelImageSet()
    {
        return !! $this->getFirstMediaUrl('default');
    }
}