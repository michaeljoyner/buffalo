<?php


use App\Orders\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_customer_can_be_created_and_persisted()
    {
        $customer = factory(\App\Customers\Customer::class)->create();

        $this->assertInstanceOf(\App\Customers\Customer::class, $customer);
    }

    /**
     *@test
     */
    public function a_customer_can_be_created_from_an_order()
    {
        $order = factory(Order::class)->create();

        $customer = \App\Customers\Customer::createFromOrder($order);

        $this->assertInstanceOf(\App\Customers\Customer::class, $customer);
        $this->assertEquals($order->company, $customer->name);
        $this->assertEquals($order->contact_person, $customer->contact_person);
        $this->assertEquals($order->phone, $customer->phone);
        $this->assertEquals($order->email, $customer->email);
        $this->assertEquals($order->fax, $customer->fax);
        $this->assertEquals($order->website, $customer->website);
        $this->assertNull($customer->address);
        $this->assertNull($customer->payment_terms);
        $this->assertNull($customer->remarks);
    }
}