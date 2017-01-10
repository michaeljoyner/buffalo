<?php


use App\Sourcing\Supplier;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuppliersControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_new_supplier_is_correctly_stored()
    {
        $this->asLoggedInUser();

        $this->post('/admin/suppliers', [
            'name'    => 'HardTack Fabricators',
            'email'   => 'supply@hardtack.con',
            'address' => '',
            'phone'   => ''
        ])
            ->assertResponseStatus(302)
            ->seeInDatabase('suppliers', [
                'name'    => 'HardTack Fabricators',
                'email'   => 'supply@hardtack.con',
                'address' => null,
                'phone'   => null
            ]);
    }

    /**
     * @test
     */
    public function a_suppliers_info_is_correctly_updated()
    {
        $supplier = factory(Supplier::class)->create();

        $this->asLoggedInUser();
        $this->post('/admin/suppliers/' . $supplier->id, [
            'name'    => 'HardTack Fabricators',
            'email'   => 'supply@hardtack.con',
            'address' => '',
            'phone'   => '042456897'
        ])
            ->assertResponseStatus(302)
            ->seeInDatabase('suppliers', [
                'id'      => $supplier->id,
                'name'    => 'HardTack Fabricators',
                'email'   => 'supply@hardtack.con',
                'address' => null,
                'phone'   => '042456897'
            ]);

    }

    /**
     *@test
     */
    public function a_supplier_can_be_deleted()
    {
        $supplier = factory(Supplier::class)->create();

        $this->asLoggedInUser();

        $this->delete('/admin/suppliers/' . $supplier->id)
            ->assertResponseStatus(302)
            ->assertSoftDeleted($supplier);
    }
}