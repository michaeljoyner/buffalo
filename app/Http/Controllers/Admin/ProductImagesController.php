<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductImagesController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $this->validate($request, ['file' => 'required|image']);

        $image = $product->setImage($request->file('file'));

        return response()->json($image);
    }
}
