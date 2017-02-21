<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSuppliesApiController extends Controller
{
    public function index(Product $product)
    {
        return $product->supplies()->with('supplier')->get();
    }
}
