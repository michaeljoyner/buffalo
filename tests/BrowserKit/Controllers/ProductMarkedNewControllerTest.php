<?php


use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductMarkedNewControllerTest extends BrowserKitTestCase
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

    /**
     *@test
     */
    public function a_product_gets_marked_new_for_the_correct_number_of_days()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();

        $this->post('/admin/products/' . $product->id . '/markednew', ['new' => true, 'days' => 34])
            ->assertResponseOk()
            ->seeJson(['new_state' => true, 'days_new' => 34]);

        $this->seeInDatabase('products', [
            'id' => $product->id,
            'marked_new' => 1
        ]);

        $product = $product->fresh();
        $this->assertEquals(34, $product->new_until->diffInDays(\Carbon\Carbon::now()));
    }

    /**
     *@test
     */
    public function a_product_can_be_marked_as_not_new()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();

        $this->post('/admin/products/' . $product->id . '/markednew', ['new' => false])
            ->assertResponseOk()
            ->seeJson(['new_state' => false]);

        $this->seeInDatabase('products', [
            'id' => $product->id,
            'marked_new' => 0
        ]);

        $product = $product->fresh();
        $this->assertNull($product->new_until);
    }
}