<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BlogPostImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('bindings');
    }

    public function store(Request $request, Post $post)
    {
        $this->validate($request, ['file' => 'required']);

        $image = $post->addImage($request->file('file'));

        return response()->json(['location' => $image->getUrl('web')]);
    }
}
