<?php


use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrderToCustomerControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_customer_is_correctly_stored_and_the_user_sent_to_its_edit_screen()
    {
        $order = factory(\App\Orders\Order::class)->create();
        $this->asLoggedInUser();

        $this->post('/admin/customers/from-order/' . $order->id)
            ->assertResponseStatus(302)
            ->seeInDatabase('customers', [
                'name' => $order->company,
                'contact_person' => $order->contact_person,
                'email' => $order->email
            ]);
        //todo assert that redirect path is the customer edit url
    }
}