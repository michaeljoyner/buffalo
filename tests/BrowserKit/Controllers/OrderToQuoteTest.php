<?php


use App\Customers\Customer;
use App\Orders\Order;
use App\Quotes\Quote;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrderToQuoteTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function the_correct_customer_select_options_are_given_on_the_page_when_starting_quote_from_order()
    {
        $customerA = factory(Customer::class)->create([
            'name'  => 'Happy Hardware',
            'email' => 'happy@example.com'
        ]);
        $customerB = factory(Customer::class)->create([
            'name'  => 'Happy hardware',
            'email' => 'hardware@example.com'
        ]);
        $customerC = factory(Customer::class)->create(['name' => 'Sad Hardware']);

        $order = factory(Order::class)->create(['company' => 'happy Hardware']);

        $this->asLoggedInUser();
        $this->visit('/admin/orders/' . $order->id . '/start-quote')
            ->see('/admin/customers/' . $customerA->id . '/quotes')
            ->see('/admin/customers/' . $customerB->id . '/quotes')
            ->see('</customer-search>')
            ->see('/admin/quotes');
    }

    /**
     *@test
     */
    public function a_quote_is_correctly_created_for_a_given_customer_from_a_given_order()
    {
        $productA = factory(\App\Products\Product::class)->create();
        $productB = factory(\App\Products\Product::class)->create();
        $order = factory(Order::class)->create();
        $order->addItem($productA, 2);
        $order->addItem($productB, 12);
        $customer = Customer::createFromOrder($order);

        $this->asLoggedInUser();
        $this->post('/admin/customers/' . $customer->id . '/quotes', [
            'order_id' => $order->id
        ])
            ->assertResponseStatus(302)
            ->seeInDatabase('quotes', [
            'customer_id' => $customer->id,
            'order_id' => $order->id
        ]);

        $quote = \App\Quotes\Quote::where('customer_id', $customer->id)->first();

        $this->seeInDatabase('quote_items', [
            'quote_id' => $quote->id,
            'product_id' => $productA->id
        ]);

        $this->seeInDatabase('quote_items', [
            'quote_id' => $quote->id,
            'product_id' => $productB->id
        ]);

        $this->assertCount(2, $quote->items);
    }

    /**
     *@test
     */
    public function a_quote_is_properly_stored_for_a_given_order_with_no_customer()
    {
        $productA = factory(\App\Products\Product::class)->create();
        $productB = factory(\App\Products\Product::class)->create();
        $order = factory(Order::class)->create();
        $order->addItem($productA, 2);
        $order->addItem($productB, 12);

        $this->asLoggedInUser();
        $this->post('/admin/quotes', [
            'order_id' => $order->id
        ])->assertResponseStatus(302)
            ->seeInDatabase('quotes', [
                'order_id' => $order->id
            ]);

        $quote = \App\Quotes\Quote::where('order_id', $order->id)->first();

        //check customer is correctly created
        $this->assertCount(1, Customer::all());
        $customer = Customer::first();
        $this->assertEquals($order->company, $customer->name);
        $this->assertEquals($order->email, $customer->email);

        $this->seeInDatabase('quote_items', [
            'quote_id' => $quote->id,
            'product_id' => $productA->id
        ]);

        $this->seeInDatabase('quote_items', [
            'quote_id' => $quote->id,
            'product_id' => $productB->id
        ]);

        $this->assertCount(2, $quote->items);
    }

    /**
     *@test
     */
    public function an_order_id_is_required_if_no_customer_is_present_for_quote()
    {
        $this->disableExceptionHandling();
        $this->asLoggedInUser();

        try {
            $this->post('/admin/quotes', []);
        } catch (Exception $e) {
            $this->assertEquals('Must have order id if no customer given', $e->getMessage());
            return;
        }
        $this->fail('Should have thrown exception');
    }
}