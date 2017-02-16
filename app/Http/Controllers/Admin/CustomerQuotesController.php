<?php

namespace App\Http\Controllers\Admin;

use App\Customers\Customer;
use App\Http\Requests\NewQuoteRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerQuotesController extends Controller
{
    public function store(NewQuoteRequest $request, Customer $customer)
    {
        $quote = $request->makeQuote($customer);

        return redirect('admin/quotes/' . $quote->id);
    }
}
