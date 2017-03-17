<?php

namespace App\Http\Controllers\Admin;

use App\Customers\Customer;
use App\Http\FlashMessaging\Flasher;
use App\Http\Requests\CustomerForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomersController extends Controller
{

    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function index()
    {
        $customers = Customer::latest()->paginate(20);

        return view('admin.customers.index')->with(compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load('quotes');
        return view('admin.customers.show')->with(compact('customer'));
    }

    public function store(CustomerForm $request)
    {
        $customer = Customer::create($request->requiredFields());

        $this->flasher->success('Customer Created', 'Yay, a new customer!');

        return redirect('admin/customers/' . $customer->id);
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit')->with(compact('customer'));
    }

    public function update(CustomerForm $request, Customer $customer)
    {
        $customer->update($request->requiredFields());

        $this->flasher->success('Customer Updated', 'Your changes have been saved.');

        return redirect('admin/customers/' . $customer->id);
    }

    public function delete(Customer $customer)
    {
        $customer->delete();

        $this->flasher->success('Customer Created', 'The record has been removed from the database');

        return redirect('admin/customers');
    }
}
