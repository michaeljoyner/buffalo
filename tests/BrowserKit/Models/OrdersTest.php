<?php
use App\Orders\Order;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/3/16
 * Time: 3:04 PM
 */
class OrdersTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function an_order_can_be_created_and_persisted()
    {
        factory(Order::class)->create([
            'company'        => 'Acme company',
            'contact_person' => 'Mc Hammer',
            'phone'          => '0123456789',
            'email'          => 'joe@example.com'
        ]);

        $this->seeInDatabase('orders', [
            'company'        => 'Acme company',
            'contact_person' => 'Mc Hammer',
            'phone'          => '0123456789',
            'email'          => 'joe@example.com'
        ]);
    }

    /**
     * @test
     */
    public function items_can_be_added_to_order_and_are_persisted()
    {
        $order = factory(Order::class)->create();
        $product = factory(Product::class)->create();

        $order->addItem($product, 2);

        $this->seeInDatabase('order_items', [
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'name'       => $product->name,
            'quantity'   => 2
        ]);
        $this->assertCount(1, $order->items);
    }

    /**
     *@test
     */
    public function an_order_can_be_archived()
    {
        $order = factory(Order::class)->create();
        $this->assertFalse($order->archived);

        $order->archive();
        $this->assertTrue($order->archived);
    }

    /**
     *@test
     */
    public function an_archived_order_may_be_restored()
    {
        $order = factory(Order::class)->create();
        $order->archive();
        $this->assertTrue($order->archived);

        $order->restore();
        $this->assertFalse($order->archived);
    }
}