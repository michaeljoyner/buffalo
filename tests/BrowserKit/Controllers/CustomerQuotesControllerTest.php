<?php


use App\Customers\Customer;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomerQuotesControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_quotes_is_correctly_stored_for_the_customer()
    {
        $customer = factory(Customer::class)->create();

        $this->asLoggedInUser();
        $this->post('/admin/customers/' . $customer->id . '/quotes')
            ->assertResponseStatus(302)
            ->seeInDatabase('quotes', ['customer_id' => $customer->id]);
    }
}