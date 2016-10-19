<?php

namespace App\Http\Controllers\Admin;

use App\SiteContent\Slide;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SlidesOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('superauth');
    }

    public function edit()
    {
        $slides = Slide::inOrder();
        return view('admin.content.slides.sort')->with(compact('slides'));
    }

    public function update(Request $request)
    {
        $this->validate($request, ['order' => 'required|array', 'order.*' => 'integer']);

        Slide::setOrder($request->order);

        return response()->json('ok');
    }
}
