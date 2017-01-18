<?php


use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuppliesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_supply_can_be_created_and_persisted()
    {
        $supply = factory(Supply::class)->create();

        $this->assertInstanceOf(Supply::class, $supply);
    }

    /**
     *@test
     */
    public function a_supply_has_a_persistable_currency()
    {
        $supply = factory(Supply::class)->create(['currency' => 'NTD']);

        $this->seeInDatabase('supplies', ['id' => $supply->id, 'currency' => 'NTD']);
    }
}