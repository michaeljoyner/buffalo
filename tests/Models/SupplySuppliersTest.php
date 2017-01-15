<?php


use Illuminate\Foundation\Testing\DatabaseMigrations;

class SupplySuppliersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_supply_has_a_supplier()
    {
        $supplier = factory(\App\Sourcing\Supplier::class)->create();
        $supply = factory(\App\Sourcing\Supply::class)->create(['supplier_id' => $supplier->id]);

        $this->assertEquals($supplier->id, $supply->supplier->id);
        $this->assertEquals($supplier->name, $supply->supplier->name);
    }
}