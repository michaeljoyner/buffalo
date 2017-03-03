<?php


use App\Customers\Customer;
use App\Orders\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_customer_can_be_created_and_persisted()
    {
        $customer = factory(Customer::class)->create();

        $this->assertInstanceOf(Customer::class, $customer);
    }

    /**
     * @test
     */
    public function a_customer_can_be_created_from_an_order()
    {
        $order = factory(Order::class)->create();

        $customer = Customer::createFromOrder($order);

        $this->assertInstanceOf(Customer::class, $customer);
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

    /**
     * @test
     */
    public function customers_that_match_on_an_orders_company_email_or_contact_person_can_be_queried()
    {
        $order = factory(Order::class)->create([
            'company' => 'harry Hardware',
            'email' => 'harry@example.com',
            'contact_person' => 'Harry Hardman'
        ]);
        $customerA = factory(Customer::class)->create(['name' => 'Harry Hardware']);
        $customerB = factory(Customer::class)->create(['email' => 'harry@example.com']);
        $customerC = factory(Customer::class)->create(['contact_person' => 'Harry hardman']);
        $customerD = factory(Customer::class)->create(['name' => 'Totally Different']);

        $matches = Customer::matchingOrder($order);

        $this->assertCount(3, $matches);
        $this->assertTrue($matches->contains($customerA));
        $this->assertTrue($matches->contains($customerB));
        $this->assertTrue($matches->contains($customerC));
        $this->assertFalse($matches->contains($customerD));
    }

    /**
     *@test
     */
    public function customers_have_a_terms_field()
    {
        $customer = factory(Customer::class)->create(['terms' => 'FOB example terms']);

        $customer->terms = 'New terms';
        $customer->save();

        $this->assertEquals('New terms', $customer->fresh()->terms);
    }
}