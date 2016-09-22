<?php

use App\Orders\Order;
use App\Orders\OrderItem;
use App\Products\Product;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1,3) as $index) {
            $order = factory(Order::class)->create();
            $products  = Product::all()->shuffle()->take(3);
            $order->addItem($products[0], 3);
            $order->addItem($products[1], 5);
            $order->addItem($products[2], 7);
        }
    }
}
