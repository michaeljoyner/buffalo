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
}