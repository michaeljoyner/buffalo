<?php

namespace App\Http\Controllers;

use App\SiteContent\Slide;
use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
    public function home()
    {
        $slide = Slide::inOrder()->first();
        return view('front.home.page')->with(compact('slide'));
    }
}
