<?php


use App\Customers\Customer;
use App\Quotes\Quote;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ClonedCustomerQuotesControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_cloned_quote_is_correctly_stored_on_the_customer()
    {
        $quote = factory(Quote::class)->create();
        $newCustomer = factory(Customer::class)->create();
        $this->asLoggedInUser();

        $this->post('/admin/customers/' . $newCustomer->id . '/clone-quote/' . $quote->id)
            ->assertResponseStatus(302);

        $this->seeInDatabase('quotes', ['customer_id' => $newCustomer->id]);
        $this->assertCount(2, Quote::all());
    }
}