<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsApiController extends Controller
{
    public function show(Product $product)
    {
        $product->load('supplies.supplier');
        return $product;
    }
}
