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

        $this->post('/admin/products/' . $product->id . '/promote', ['promote' => true, 'promote_until' => '2017-01-01'])
            ->assertResponseOk()
            ->seeJson(['new_state' => true]);

        $product = $product->fresh();
        $this->assertTrue($product->isPromoted());
    }

    /**
     *@test
     */
    public function a_promoted_product_can_be_demoted_by_posting_to_endpoint()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create(['promoted_until' => \Carbon\Carbon::now()->addDays(30)]);

        $this->post('/admin/products/' . $product->id . '/promote', ['promote' => false])
            ->assertResponseOk()
            ->seeJson(['new_state' => false]);

        $product = $product->fresh();
        $this->assertFalse($product->isPromoted());
    }
}