<?php


use App\Products\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductPackagingTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function packaging_can_be_added_to_a_product()
    {
        $packageData = [
            'type' => 'Hanger',
            'unit' => 'PC',
            'inner' => 32,
            'outer' => 96,
            'carton' => '72 inch',
            'net_weight' => 1.55,
            'gross_weight' => 2.6
        ];
        $product = factory(Product::class)->create();

        $product->addPackaging($packageData);
        $package = $product->fresh()->getPackaging();
        $this->assertEquals('Hanger', $package->type);
        $this->assertEquals('PC', $package->unit);
        $this->assertEquals(32, $package->inner);
        $this->assertEquals(96, $package->outer);
        $this->assertEquals('72 inch', $package->carton);
        $this->assertEquals(1.55, $package->net_weight);
        $this->assertEquals(2.6, $package->gross_weight);
    }

    /**
     *@test
     */
    public function get_package_returns_the_latest_package_if_exists()
    {
        $product = factory(Product::class)->create();
        factory(\App\Products\Packaging::class)->create([
            'created_at' => Carbon::parse('-2 hours'),
            'product_id' => $product->id
        ]);
        $packageB = factory(\App\Products\Packaging::class)->create([
            'created_at' => Carbon::parse('-1 hours'),
            'product_id' => $product->id
        ]);

        $package = $product->getPackaging();

        $this->assertEquals($package->id, $packageB->id);
    }

    /**
     *@test
     */
    public function get_packaging_returns_a_new_instance_of_packaging_when_no_package_exists()
    {
        $product = factory(Product::class)->create();

        $package = $product->getPackaging();

        $this->assertInstanceOf(\App\Products\Packaging::class, $package);
        $this->assertNull($package->id);
    }
}