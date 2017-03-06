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
        $this->validate($request, [
            'product_ids' => 'required|array',
            'product_ids.*' => 'integer|exists:products,id'
        ]);

        collect(request('product_ids'))->each(function($id) use ($quote) {
            $quote->addItem(Product::find($id));
        });

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
