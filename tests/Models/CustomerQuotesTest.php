<?php


use App\Customers\Customer;
use App\Orders\Order;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomerQuotesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_customer_can_create_a_quote()
    {
        $customer = factory(Customer::class)->create();

        $quote = $customer->newQuote();

        $this->assertEquals($customer->id, $quote->customer_id);
        $this->assertNull($quote->order_id);
        $this->assertCount(0, $quote->items);
    }

    /**
     *@test
     */
    public function a_customer_can_create_a_quote_from_an_order()
    {
        $customer = factory(Customer::class)->create();
        $productA = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $order = factory(Order::class)->create();
        $order->addItem($productA, 10);
        $order->addItem($productB, 10);

        $quote = $customer->newQuote($order);

        $this->assertEquals($customer->id, $quote->customer_id);
        $this->assertEquals($order->id, $quote->order_id);
        $this->assertCount(2, $quote->items);
    }

    /**
     *@test
     */
    public function a_quote_created_for_a_customer_has_the_customers_payment_terms_and_terms()
    {
        $customer = factory(Customer::class)->create();

        $quote = $customer->newQuote();

        $this->assertEquals($customer->payment_terms, $quote->payment_terms);
        $this->assertEquals($customer->terms, $quote->terms);
        $this->assertNotNull($customer->terms);
        $this->assertNotNull($customer->payment_terms);
    }

    /**
     *@test
     */
    public function a_created_quote_has_a_default_valid_until_date_of_30_days_later()
    {
        $customer = factory(Customer::class)->create();

        $quote = $customer->newQuote();

        $this->assertTrue(\Carbon\Carbon::parse('+30 days')->isSameDay($quote->valid_until));
    }
}