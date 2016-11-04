<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductMarkedNewController extends Controller
{
    public function update(Request $request, Product $product)
    {
        $this->validate($request, ['new' => 'required|boolean']);

        $new_state = $product->markAsNew($request->get('new'));

        return response()->json(['new_state' => $new_state]);
    }
}
