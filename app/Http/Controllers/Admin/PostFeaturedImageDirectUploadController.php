<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostFeaturedImageDirectUploadController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $this->validate($request, ['file' => 'required|image']);
        $image = $post->addImage($request->file('file'));

        $post->setFeaturedImage($image);

        return response()->json([
            'url' => $image->getUrl(),
            'thumb' => $image->getUrl('thumb'),
            'id' => $image->id,
            'is_feature' => true
        ]);
    }
}
