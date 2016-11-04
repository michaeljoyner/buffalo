<?php


use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductMarkedNewControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_gets_marked_as_new_by_posting_to_endpoint()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();

        $this->post('/admin/products/' . $product->id . '/markednew', ['new' => true])
            ->assertResponseOk()
            ->seeJson(['new_state' => true]);

        $this->seeInDatabase('products', [
            'id' => $product->id,
            'marked_new' => 1
        ]);
    }
}