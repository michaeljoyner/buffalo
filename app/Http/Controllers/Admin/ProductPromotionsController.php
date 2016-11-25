<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductPromotionsController extends Controller
{
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'promote' => 'required|boolean',
            'promote_until' => 'required_if:promote,true|date|after:today'
        ]);

        $new_state = $request->promote ? $product->promote(new Carbon($request->promote_until)) : $product->demote();

        return response()->json(['new_state' => $new_state]);
    }
}
