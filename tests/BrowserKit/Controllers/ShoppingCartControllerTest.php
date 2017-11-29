<?php
use App\Products\Product;
use App\Shopping\ShoppingCart;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/3/16
 * Time: 11:48 AM
 */
class ShoppingCartControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_product_can_be_added_to_the_cart_by_posting_to_an_endpoint()
    {
        $product = factory(Product::class)->create();
        $cart = $this->app->make(ShoppingCart::class);

        $response = $this->call('POST', '/api/cart/items', [
            'product_id' => $product->id,
            'quantity'   => 2
        ]);
        $this->assertOkResponse($response);
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

        $response = $this->call('POST', '/api/cart/items/' . $product->id, [
            'quantity' => 5
        ]);
        $this->assertOkResponse($response);

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

        $response = $this->call('DELETE', '/api/cart/items/' . $product->id);
        $this->assertOkResponse($response);

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
        $product2 = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $cart->addItem($product2, 2);

        $this->get('/api/cart/items')
            ->seeJsonStructure([
                '*' => ['id', 'rowId', 'name', 'quantity']
            ])
            ->seeJson([
                'id'       => $product->id,
                'quantity' => 1,
                'name'     => $product->name
            ])
            ->seeJson([
                'id'       => $product2->id,
                'quantity' => 2,
                'name'     => $product2->name
            ]);
    }

    /**
     * @test
     */
    public function a_summary_of_the_cart_quantities_can_be_fetched_via_api()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $cart->addItem($product2, 2);

        $this->get('/api/cart/summary')
            ->assertResponseOk()
            ->seeJson([
                'total_items'    => 3,
                'total_products' => 2
            ]);
    }
}