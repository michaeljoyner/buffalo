<?php


use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomerApiTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function the_complete_list_of_customers_can_be_fetched()
    {
        $customerA = factory(\App\Customers\Customer::class)->create();
        $customerB = factory(\App\Customers\Customer::class)->create();
        $customerC = factory(\App\Customers\Customer::class)->create();

        $this->asLoggedInUser();
        $this->get('/admin/api/customers')
            ->assertResponseOk()
            ->seeJsonForCustomer($customerA)
            ->seeJsonForCustomer($customerB)
            ->seeJsonForCustomer($customerC);
    }

    protected function seeJsonForCustomer($customer)
    {
        $this->seeJsonContains([
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'contact_person' => $customer->contact_person
        ]);

        return $this;
    }
}