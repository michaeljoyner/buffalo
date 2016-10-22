<?php


use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductPromotionControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_can_be_promoted_by_posting_to_endpoint()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();

        $this->post('/admin/products/' . $product->id . '/promote', ['promote' => true])
            ->assertResponseOk()
            ->seeJson(['new_state' => true]);

        $product = Product::find($product->id);
        $this->assertTrue($product->is_promoted);
    }

    /**
     *@test
     */
    public function a_promoted_product_can_be_demoted_by_posting_to_endpoint()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create(['is_promoted' => true]);

        $this->post('/admin/products/' . $product->id . '/promote', ['promote' => false])
            ->assertResponseOk()
            ->seeJson(['new_state' => false]);

        $product = Product::find($product->id);
        $this->assertFalse($product->is_promoted);
    }
}