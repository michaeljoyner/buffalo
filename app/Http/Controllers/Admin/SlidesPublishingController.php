<?php

namespace App\Http\Controllers\Admin;

use App\SiteContent\Slide;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SlidesPublishingController extends Controller
{

    public function __construct()
    {
        $this->middleware('superauth');
    }

    public function update(Request $request, Slide $slide)
    {
        $this->validate($request, ['publish' => 'required|boolean']);

        $newState = $request->publish ? $slide->publish() : $slide->unpublish();

        return response()->json(['new_state' => $newState]);
    }
}
