<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use App\Orders\OrderService;
use App\Shopping\ShoppingCart;
use Illuminate\Http\Request;

use App\Http\Requests;

class CheckoutController extends Controller
{

    /**
     * @var ShoppingCart
     */
    private $cart;

    public function __construct(ShoppingCart $cart)
    {
        $this->cart = $cart;
    }

    public function doCheckout(OrderFormRequest $request)
    {
        $order = OrderService::createOrder($request->acceptedFields(), $this->cart->allItems());

        if($order) {
            $this->cart->emptyOut();
        }

        return redirect('/');
    }
}
