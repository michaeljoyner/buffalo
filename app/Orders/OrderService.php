<?php
/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/3/16
 * Time: 3:51 PM
 */

namespace App\Orders;


use App\Products\Product;

class OrderService
{
    public static function createOrder($customerDetails, $cartContents)
    {
        $order = Order::create($customerDetails);

        $cartContents->each(function($item) use ($order) {
            $order->addItem(Product::findOrFail($item->id), $item->qty);
        });

        return $order;
    }
}