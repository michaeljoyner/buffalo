<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductMarkedNewController extends Controller
{
    public function update(Request $request, Product $product)
    {
        $this->validate($request, ['new' => 'required|boolean', 'days' => 'integer|max:90|min:1']);

        $product->markAsNew($request->get('new'), $request->days);

        return response()->json([
            'new_state' => $product->isNew(),
            'days_new' => $product->new_until ? $product->new_until->diffInDays(Carbon::now()) : null
        ]);
    }
}
