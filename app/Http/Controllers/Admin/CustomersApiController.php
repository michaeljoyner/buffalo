<?php

namespace App\Http\Controllers\Admin;

use App\Customers\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomersApiController extends Controller
{
    public function index()
    {
        return Customer::all();
    }
}
