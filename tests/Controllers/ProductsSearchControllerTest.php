<?php


use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductsSearchControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
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
                'id' => $product1->id,
            ])
            ->seeJson([
                'name' => $product2->name,
                'id' => $product2->id,
            ]);
    }
}