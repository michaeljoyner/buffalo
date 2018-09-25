<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Post;
use App\Http\FlashMessaging\Flasher;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Models\Media;

class PostsFeaturedImageController extends Controller
{
    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function index(Post $post)
    {
        return $post->getMedia()->map(function($image) {
            return [
                'url' => $image->getUrl(),
                'thumb' => $image->getUrl('thumb'),
                'id' => $image->id,
                'is_feature' => $image->getCustomProperty('is_feature', false)
            ];
        })->values()->toArray();
    }

    public function store(Request $request, Post $post)
    {
        $this->validate($request, ['image_id' => 'required|integer']);
        $media = Media::findOrFail($request->image_id);

        $post->setFeaturedImage($media);

        $this->flasher->success('Featured Image Set', 'The featured image was set for the post');

        return redirect('/admin/blog/posts');
    }

    public function edit(Post $post)
    {
        return view('admin.blog.featuredimages.edit')->with(compact('post'));
    }
}
