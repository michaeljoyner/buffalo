<?php


use App\Products\Product;
use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductApiTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_with_its_supplies_is_correctly_returned()
    {
        $product = factory(Product::class)->create();
        $supplyA = factory(Supply::class)->create(['product_id' => $product->id]);
        $supplyB = factory(Supply::class)->create(['product_id' => $product->id]);

        $this->asLoggedInUser();

        $this->get('/admin/api/products/' . $product->id)
            ->assertResponseOk()
            ->seeJsonContains(['id' => $product->id, 'name' => $product->name])
            ->seeJsonStructure([
                'supplies' => [
                    ['supplier' => ['name'], 'item_number', 'id']
                ]
            ]);

        $resultAsArray = $this->decodeResponseJson();
        $resultSupplyNumbers = collect($resultAsArray['supplies'])->reduce(function($acc, $supply) {
            return $acc . ' ' . $supply['item_number'];
        }, '');
        $this->assertContains((string) $supplyA->item_number, $resultSupplyNumbers);
        $this->assertContains((string) $supplyB->item_number, $resultSupplyNumbers);

    }
}