<?php
use App\Orders\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/3/16
 * Time: 6:25 PM
 */
class OrdersAdminControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function an_order_can_be_archived_by_posting_to_endpoint()
    {
        $order = factory(Order::class)->create();
        $this->asLoggedInUser();

        $response = $this->call('POST', '/admin/orders/' . $order->id . '/archiving', [
            'current' => false
        ]);
        $this->assertOkResponse($response);

        $this->assertArraySubset(['new_state' => false], json_decode($response->getContent(), true));

        $order = Order::withTrashed()->find($order->id);
        $this->assertTrue($order->archived);
    }

    /**
     *@test
     */
    public function an_archived_order_can_be_restored_via_api_endpoint()
    {
        $order = factory(Order::class)->create();
        $order->archive();
        $this->asLoggedInUser();

        $this->post('/admin/orders/' . $order->id . '/archiving', ['current' => true])
            ->assertResponseOk()
            ->seeJson(['new_state' => true]);

        $order = Order::withTrashed()->find($order->id);
        $this->assertFalse($order->archived);
    }
}