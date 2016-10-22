<?php
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/25/16
 * Time: 9:08 AM
 */
class ProductsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_can_be_created_and_stored_in_db()
    {
        $product = factory(Product::class)->create();

        $this->assertInstanceOf(Product::class, $product);
    }

    /**
     *@test
     */
    public function a_products_availability_can_be_set()
    {
        $product = factory(Product::class)->create(['available' => 1]);
        $this->assertTrue($product->available);

        $product->makeAvailable(false);
        $this->assertFalse($product->available);

        $product->makeAvailable(true);
        $this->assertTrue($product->available);
    }

    /**
     *@test
     */
    public function a_product_is_not_promoted_by_default()
    {
        $product = factory(Product::class)->create();

        $this->assertFalse($product->is_promoted);
    }

    /**
     *@test
     */
    public function a_product_can_be_promoted()
    {
        $product = factory(Product::class)->create();
        $product->promote();

        $this->assertTrue($product->is_promoted);
    }

    /**
     *@test
     */
    public function a_product_can_be_demoted()
    {
        $product = factory(Product::class)->create(['is_promoted' => true]);
        $product->demote();

        $this->assertFalse($product->is_promoted);
    }
}