<?php


use App\Products\Product;
use App\Sourcing\Supplier;
use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuppliesControllerTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     *@test
     */
    public function a_new_supply_is_correctly_stored_on_the_product()
    {
        $product = factory(Product::class)->create();
        $supplier = factory(Supplier::class)->create();
        $this->asLoggedInUser();

        $this->post('/admin/products/' . $product->id . '/supplies', [
            'quoted_date' => '2017-01-11',
            'supplier_id' => $supplier->id,
            'item_number' => '12345',
            'price' => 1000,
            'package_price' => 20,
            'remarks' => ''
        ])->assertResponseStatus(302)
          ->seeInDatabase('supplies', [
                'product_id' => $product->id,
                'quoted_date' => '2017-01-11 00:00:00',
                'supplier_id' => $supplier->id,
                'item_number' => '12345',
                'price' => 1000,
                'package_price' => 20,
                'remarks' => null
            ]);
    }

    /**
     *@test
     */
    public function a_supply_is_correctly_deleted()
    {
        $supply = factory(Supply::class)->create();
        $this->asLoggedInUser();

        $this->delete('/admin/supplies/' . $supply->id)
            ->assertResponseStatus(302)
            ->notSeeInDatabase('supplies', ['id' => $supply->id]);
    }
}