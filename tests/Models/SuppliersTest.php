<?php


use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuppliersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_supplier_can_be_created_and_persisted()
    {
        $supplier = factory(\App\Sourcing\Supplier::class)->create();

        $this->assertInstanceOf(\App\Sourcing\Supplier::class, $supplier);
    }
}