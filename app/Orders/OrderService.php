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
        if($customerDetails['referrer'] == "other" && $customerDetails['other_referrer'] != "") {
            $customerDetails['referrer'] = $customerDetails['other_referrer'];
        }
        $order = Order::create($customerDetails);

        $cartContents->each(function($item) use ($order) {
            $order->addItem(Product::findOrFail($item['id']), $item['quantity']);
        });

        return $order;
    }
}