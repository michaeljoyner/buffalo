<?php
use App\Orders\OrderService;
use App\Products\Product;
use App\Shopping\ShoppingCart;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/3/16
 * Time: 3:39 PM
 */
class OrderServicesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_can_create_an_order_from_a_collection_of_cart_contents_and_customer_details()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $cart->addItem($product2, 2);

        $customer_details = [
            'company'        => 'Acme company',
            'contact_person' => 'Mc Hammer',
            'phone'          => '0123456789',
            'fax'            => '9876543210',
            'email'          => 'joe@example.com',
            'website'        => 'totesacme.com',
            'referrer'       => 'google',
            'requirements'   => '3 bags of wool'
        ];

        $order = OrderService::createOrder($customer_details, $cart->allItems());

        $this->assertCount(2, $order->items);
        $this->seeInDatabase('orders', $customer_details);

        $this->seeInDatabase('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'name' => $product->name,
            'quantity' => 1
        ]);

        $this->seeInDatabase('order_items', [
            'order_id' => $order->id,
            'product_id' => $product2->id,
            'name' => $product2->name,
            'quantity' => 2
        ]);
    }
}