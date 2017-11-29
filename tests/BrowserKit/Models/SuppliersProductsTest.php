<?php


use App\Products\Product;
use App\Sourcing\Supplier;
use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuppliersProductsTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_supplier_has_products()
    {
        $supplier = factory(Supplier::class)->create();
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        factory(Supply::class, 4)->create();
        factory(Supply::class)->create(['supplier_id' => $supplier->id, 'product_id' => $product1->id]);
        factory(Supply::class)->create(['supplier_id' => $supplier->id, 'product_id' => $product2->id]);

        $supplierProducts = $supplier->products();

        $this->assertCount(2, $supplierProducts);
        $this->assertEquals($product1->id, $supplierProducts->first()->id);
        $this->assertEquals($product2->id, $supplierProducts->last()->id);
    }

    /**
     *@test
     */
    public function a_product_with_multiple_supplies_from_the_same_supplier_is_not_duplicated()
    {
        $supplier = factory(Supplier::class)->create();
        $product1 = factory(Product::class)->create();
        factory(Supply::class)->create(['supplier_id' => $supplier->id, 'product_id' => $product1->id]);
        factory(Supply::class)->create(['supplier_id' => $supplier->id, 'product_id' => $product1->id]);

        $supplierProducts = $supplier->products();

        $this->assertCount(1, $supplierProducts);
    }
}