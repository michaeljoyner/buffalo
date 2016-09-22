<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SlideMediaUploadRequest;
use App\SiteContent\Slide;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SlidesMediaController extends Controller
{
    public function store(SlideMediaUploadRequest $request, Slide $slide)
    {
        if($request->isVideo()) {
            return $this->handleVideoFile($request->file('file'), $slide);
        }

        $image = $slide->putImage($request->file('file'));

        return response()->json($image);
    }

    protected function handleVideoFile($video, Slide $slide)
    {
        $path = $slide->setVideo($video);

        return response()->json($path);
    }
}
