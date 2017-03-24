<?php


use App\Sourcing\Supplier;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuppliersAuthorityTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_non_super_user_cannot_delete_a_supplier()
    {
        $this->asLoggedInUser([], \App\Role::limited());
        $supplier = factory(Supplier::class)->create();

        $this->delete('/admin/suppliers/' . $supplier->id);

        $this->assertResponseStatus(403);
        $this->assertCount(1, Supplier::where('id', $supplier->id)->get());
    }
}