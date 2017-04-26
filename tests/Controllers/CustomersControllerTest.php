<?php


use App\Customers\Customer;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomersControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_customer_is_properly_stored()
    {
        $this->asLoggedInUser();

        $this->post('/admin/customers', $this->getRawCustomerData())
            ->assertResponseStatus(302)
            ->seeInDatabase('customers', $this->expectedCustomerData());
    }

    /**
     *@test
     */
    public function a_customer_can_be_stored_with_no_email_address()
    {
        $customerData = $this->getRawCustomerData();
        $customerData['email'] = null;
        $this->asLoggedInUser();

        $this->post('/admin/customers', $customerData)
            ->assertResponseStatus(302)
            ->assertSessionMissing('errors')
            ->seeInDatabase('customers', array_merge($this->expectedCustomerData(), ['email' => null]));
    }

    /**
     *@test
     */
    public function a_customers_details_may_be_updated()
    {

        $customer = factory(Customer::class)->create();
        $this->asLoggedInUser();

        $this->post('/admin/customers/' . $customer->id, $this->getRawCustomerData())
            ->assertResponseStatus(302)
            ->seeInDatabase('customers', array_merge(['id' => $customer->id], $this->expectedCustomerData()));
    }

    /**
     *@test
     */
    public function a_customer_can_be_deleted()
    {
        $customer = factory(Customer::class)->create();
        $this->asLoggedInUser();

        $this->delete('/admin/customers/' . $customer->id)
            ->assertResponseStatus(302)
            ->notSeeInDatabase('customers', ['id' => $customer->id]);
    }

    protected function getRawCustomerData()
    {
        return [
            'name' => 'Happy Hardware',
            'contact_person' => 'Harry Hardman',
            'email' => 'harry@example.com',
            'phone' => '0123456',
            'fax' => '',
            'website' => '',
            'address' => '123 Sesame Street',
            'remarks' => 'Let us milk this guy',
            'payment_terms' => 'Easy',
            'terms' => 'FOB example terms'
        ];
    }

    protected function expectedCustomerData()
    {
        return collect($this->getRawCustomerData())->flatMap(function($value, $field) {
            return [$field => $value === '' ? null : $value];
        })->toArray();
    }
}