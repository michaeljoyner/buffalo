<?php


use App\Products\Product;
use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductSuppliesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_supply_can_be_created_for_a_product()
    {
        $supplier = factory(\App\Sourcing\Supplier::class)->create();
        $product = factory(Product::class)->create();
        $supplyData = [
            'quoted_date' => '2017-01-11',
            'supplier_id' => $supplier->id,
            'item_number' => '12345',
            'price' => 1000,
            'package_price' => 20,
            'remarks' => 'Valid for 90 days'
        ];

        $supply = $product->addSupply($supplyData);

        $this->assertInstanceOf(Supply::class, $supply);
        $this->assertEquals($supply->product_id, $product->id);
        $this->assertCount(1, $product->supplies);
    }

    /**
     *@test
     */
    public function a_supply_belongs_to_a_product()
    {
        $product = factory(Product::class)->create();
        $supply = factory(Supply::class)->create(['product_id' => $product->id]);

        $this->assertEquals($product->id, $supply->product->id);
    }

    /**
     *@test
     */
    public function a_supply_price_can_be_a_float()
    {
        $supply = factory(Supply::class)->create(['price' => 33.33]);
        $databasePrice = $supply->fresh()->price;

        //multiply by 1 to ensure not testing with string value
        $this->assertTrue(is_float($supply->fresh()->price * 1), "Failed to assert that $databasePrice is a float");
    }

    /**
     *@test
     */
    public function a_product_supply_has_a_valid_until_date()
    {
        $supply = factory(Supply::class)->create(['valid_until' => \Carbon\Carbon::parse('+30 days')]);

        $this->assertNotNull($supply->fresh()->valid_until);
        $this->assertTrue($supply->fresh()->valid_until->subDays(30)->isToday());
    }
}