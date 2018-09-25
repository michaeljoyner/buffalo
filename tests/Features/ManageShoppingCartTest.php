<?php

namespace Tests\Feature;

use App\Products\Product;
use App\Shopping\ShoppingCart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageShoppingCartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_product_can_be_added_to_the_cart_by_posting_to_an_endpoint()
    {
        $product = factory(Product::class)->create();
        $cart = $this->app->make(ShoppingCart::class);

        $response = $this->postJson('/api/cart/items', [
            'product_id' => $product->id,
            'quantity'   => 2
        ]);
        $response->assertStatus(200);
        $this->assertEquals(2, $cart->quantityOf($product));
    }

    /**
     * @test
     */
    public function the_quantity_of_an_item_can_be_updated_by_posting_to_endpoint()
    {
        $product = factory(Product::class)->create();
        $cart = $this->app->make(ShoppingCart::class);
        $cart->addItem($product, 1);

        $response = $this->postJson('/api/cart/items/' . $product->id, [
            'quantity' => 5
        ]);

        $response->assertStatus(200);
        $this->assertEquals(5, $cart->quantityOf($product));
    }

    /**
     * @test
     */
    public function a_product_may_be_removed_from_the_cart_via_api_call()
    {
        $product = factory(Product::class)->create();
        $cart = $this->app->make(ShoppingCart::class);
        $cart->addItem($product, 1);

        $response = $this->deleteJson('/api/cart/items/' . $product->id);
        $response->assertStatus(200);

        $this->assertEquals(0, $cart->quantityOf($product));
        $this->assertCount(0, $cart->allItems());
    }

    /**
     * @test
     */
    public function the_carts_contents_can_be_fetched_via_get_request_to_api_endpoint()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $cart->addItem($productB, 2);

        $response = $this->getJson('/api/cart/items');
        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([
            'id'       => $product->id,
            'quantity' => 1,
            'name'     => $product->name
        ]);
        $response->assertJsonFragment([
            'id'       => $productB->id,
            'quantity' => 2,
            'name'     => $productB->name
        ]);
    }

    /**
     * @test
     */
    public function a_summary_of_the_cart_quantities_can_be_fetched_via_api()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $cart->addItem($productB, 2);

        $response = $this->getJson('/api/cart/summary');
        $response->assertStatus(200);

        $response->assertJson([
            'total_items'    => 3,
            'total_products' => 2
        ]);

    }
}