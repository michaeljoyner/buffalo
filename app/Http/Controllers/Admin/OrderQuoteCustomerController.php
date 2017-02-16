<?php

namespace App\Http\Controllers\Admin;

use App\Customers\Customer;
use App\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderQuoteCustomerController extends Controller
{
    public function show(Order $order)
    {
        $suggestedCustomers = Customer::matchingOrder($order);
        return view('admin.quotes.customers.select')->with(compact('order', 'suggestedCustomers'));
    }
}
