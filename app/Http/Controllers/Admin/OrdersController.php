<?php

namespace App\Http\Controllers\Admin;

use App\Orders\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(15);

        return view('admin.orders.index')->with(compact('orders'));
    }

    public function archived()
    {
        $orders = Order::onlyTrashed()->latest()->paginate(15);

        return view('admin.orders.index')->with(compact('orders'));
    }

    public function show($order)
    {
        $order = Order::withTrashed()->with('items')->findOrFail($order);

        return view('admin.orders.show')->with(compact('order'));
    }

    public function setArchiveStatus(Request $request, $order)
    {
        $this->validate($request, ['current' => 'required|boolean']);

        $order = Order::withTrashed()->findOrFail($order);

        $request->current ? $order->restore() : $order->archive();

        return response()->json(['new_state' => !$order->archived]);
    }
}
