<?php


use App\Sourcing\Supplier;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuppliersTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_supplier_can_be_created_and_persisted()
    {
        $supplier = factory(Supplier::class)->create();

        $this->assertInstanceOf(Supplier::class, $supplier);
    }

    /**
     * @test
     */
    public function a_supplier_has_a_persistable_contact_person_and_website()
    {
        $supplier = factory(Supplier::class)->create(['website' => 'http://acme.con', 'contact_person' => 'Bob Rob']);

        $this->seeInDatabase('suppliers', [
            'id'             => $supplier->id,
            'website'        => 'http://acme.con',
            'contact_person' => 'Bob Rob'
        ]);
    }
}