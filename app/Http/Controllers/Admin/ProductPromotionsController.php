<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductPromotionsController extends Controller
{
    public function update(Request $request, Product $product)
    {
        $this->validate($request, ['promote' => 'required|boolean']);

        $request->promote ? $product->promote() : $product->demote();

        return response()->json(['new_state' => $product->is_promoted]);
    }
}
