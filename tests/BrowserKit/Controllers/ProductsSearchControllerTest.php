<?php


use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductsSearchControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function search_results_can_be_queried_via_api_endpoint()
    {
        $product1 = factory(Product::class)->create(['product_code' => 'COOL']);
        $product2 = factory(Product::class)->create(['name' => 'Totally uncool thing']);

        $this->asLoggedInUser();

        $this->post('/admin/api/products/search', ['searchterm' => 'cool'])
            ->assertResponseOk()
            ->seeJson([
                'name' => $product1->name,
                'id'   => $product1->id,
            ])
            ->seeJson([
                'name' => $product2->name,
                'id'   => $product2->id,
            ]);
    }

    /**
     * @test
     */
    public function the_response_from_a_search_includes_the_factory_item_number_if_searched_for_by_it()
    {
        $supply = factory(\App\Sourcing\Supply::class)->create(['item_number' => 'ABC123']);

        $this->asLoggedInUser();

        $this->post('/admin/api/products/search', ['searchterm' => 'ABC123'])
            ->assertResponseOk();

        $responseData = $this->readJson();
        $this->assertCount(1, $responseData);
        $this->seeJson([
            'id'             => $supply->product->id,
            'name'           => $supply->product->name,
            'factory_number' => $supply->item_number
        ]);
    }
}