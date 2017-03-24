<?php


use App\Customers\Customer;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomersAuthorityTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_non_super_admin_can_not_delete_a_customer()
    {
        $this->asLoggedInUser([], \App\Role::limited());
        $customer = factory(Customer::class)->create();

        $this->delete('/admin/customers/' . $customer->id);

        $this->assertResponseStatus(403);
        $this->assertCount(1, Customer::where('id', $customer->id)->get());
    }
}