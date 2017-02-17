<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuoteItemUpdate;
use App\Products\Product;
use App\Quotes\Quote;
use App\Quotes\QuoteItem;
use App\Sourcing\Supply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuoteItemsController extends Controller
{

    public function index(Quote $quote)
    {
            return $quote->items;
    }

    public function store(Request $request, Quote $quote)
    {
        $this->validate($request, ['product_id' => 'required|exists:products,id']);

        $quote->addItem(
            Product::findOrFail($request->product_id),
            request('quantity', 1),
            Supply::find(request('supply_id', null))
        );

        return response()->json([], 201);
    }

    public function update(QuoteItemUpdate $request, QuoteItem $item)
    {
        $item->update($request->fieldsToUpdate());

        return $item->fresh();
    }

    public function delete(QuoteItem $item)
    {
        $item->delete();

        return response()->json([]);
    }
}
