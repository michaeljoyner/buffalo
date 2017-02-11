<?php

namespace App\Http\Controllers\Admin;

use App\Customers\Customer;
use App\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderToCustomerController extends Controller
{
    public function store(Order $order)
    {
        $customer = Customer::createFromOrder($order);

        return redirect('admin/customers/' . $customer->id . '/edit');
    }
}
