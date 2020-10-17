<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductGalleryImagesController extends Controller
{

    public function index(Product $product)
    {
        $images = $product->galleryImages()->map(function($image) {
            return [
                'image_id' => $image->id,
                'src' => $image->getUrl(),
                'thumb_src' => $image->getUrl('thumb')
            ];
        })->toArray();
        return response()->json($images);
    }

    public function store(Request $request, Product $product)
    {
        $this->validate($request, ['file' => 'required|image']);

        $image = $product->addGalleryImage($request->file('file'));

        return response()->json([
            'image_id' => $image->id,
            'src' => $image->getUrl(),
            'thumb_src' => $image->getUrl('thumb')
        ]);
    }

    public function delete(Product $product, Media $media)
    {
        if($product->getGallery()->id === $media->model->id) {
            $media->delete();
        }
        return response()->json('ok');
    }
}
