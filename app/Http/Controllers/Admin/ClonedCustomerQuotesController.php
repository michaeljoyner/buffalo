<?php

namespace App\Http\Controllers\Admin;

use App\Customers\Customer;
use App\Quotes\Quote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClonedCustomerQuotesController extends Controller
{
    public function store(Customer $customer, Quote $quote)
    {
        $newQuote = $quote->cloneFor($customer);

        return redirect('/admin/quotes/' . $newQuote->id);
    }
}
