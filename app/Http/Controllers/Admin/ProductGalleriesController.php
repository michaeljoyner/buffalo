<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductGalleriesController extends Controller
{
    public function show(Product $product)
    {
        return view('admin.products.gallery')->with(compact('product'));
    }
}
