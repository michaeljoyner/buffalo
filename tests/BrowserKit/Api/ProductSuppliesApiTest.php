<?php


use App\Products\Product;
use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductSuppliesApiTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_products_supplies_may_be_fetched()
    {
        $product = factory(Product::class)->create();
        $supplyA = factory(Supply::class)->create(['product_id' => $product->id]);
        $supplyB = factory(Supply::class)->create(['product_id' => $product->id]);

        $this->asLoggedInUser();

        $this->get('/admin/api/products/' . $product->id . '/supplies')
            ->assertResponseOk()
            ->assertJsonForSupply($supplyA)
            ->assertJsonForSupply($supplyB);

    }

    protected function assertJsonForSupply($supply)
    {
        $this->seeJsonContains([
            'id' => $supply->id,
            'item_number' => $supply->item_number,
            'currency' => $supply->currency,
            'price' => $supply->price,
            'package_price' => $supply->package_price,
            'remarks' => $supply->remarks
        ]);

        return $this;
    }
}