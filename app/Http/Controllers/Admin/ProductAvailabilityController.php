<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductAvailabilityController extends Controller
{
    public function update(Request $request, Product $product)
    {
        $this->validate($request, ['available' => 'required|boolean']);

        $productState = $product->makeAvailable($request->available);

        return response()->json(['new_state' => $productState]);
    }
}
