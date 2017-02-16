<?php

namespace App\Http\Controllers\Admin;

use App\Customers\Customer;
use App\Http\Requests\NewQuoteRequest;
use App\Http\Requests\QuoteUpdate;
use App\Orders\Order;
use App\Quotes\Quote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuotesController extends Controller
{
    public function index()
    {
        $quotes = Quote::latest()->paginate(18);

        return view('admin.quotes.index')->with(compact('quotes'));
    }

    public function show(Quote $quote)
    {
        return view('admin.quotes.show')->with(compact('quote'));
    }

    public function store(NewQuoteRequest $request)
    {
        $quote = $request->makeQuote();

        return redirect('admin/quotes/' . $quote->id);
    }

    public function edit(Quote $quote)
    {
        return view('admin.quotes.edit')->with(compact('quote'));
    }

    public function update(QuoteUpdate $request, Quote $quote)
    {
        $quote->update($request->requiredFields());

        return redirect('/admin/quotes/' . $quote->id);
    }
}
