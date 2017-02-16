<?php

namespace App\Http\Controllers\Admin;

use App\Quotes\Quote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuoteQuoteItemsController extends Controller
{
    public function edit(Quote $quote)
    {
        return view('admin.quotes.items.edit')->with(compact('quote'));
    }
}
