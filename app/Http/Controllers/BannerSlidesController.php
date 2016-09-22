<?php

namespace App\Http\Controllers;

use App\SiteContent\Slide;
use Illuminate\Http\Request;

use App\Http\Requests;

class BannerSlidesController extends Controller
{
    public function index()
    {
        return Slide::inOrder()->filter(function ($slide) {
            return $slide->isComplete() && $slide->is_published;
        })->map(function ($slide) {
            return [
                'id'          => $slide->id,
                'image_src'   => $slide->modelImage('large'),
                'is_video'    => $slide->is_video,
                'video'       => $slide->video,
                'slide_text'  => $slide->slide_text,
                'action_text' => $slide->action_text,
                'action_link' => $slide->action_link,
                'position'    => $slide->position,
                'text_colour' => $slide->text_colour,
                'is_ready'    => false
            ];
        })->values();
    }
}
