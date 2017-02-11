<?php


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
}