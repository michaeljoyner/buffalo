<?php
use App\Products\Product;
use App\Shopping\ShoppingCart;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/3/16
 * Time: 11:15 AM
 */
class ShoppingCartTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_can_be_stored_in_the_shopping_cart()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();

        $cart->addItem($product, 1);
        $this->assertCount(1, $cart->allItems());
    }

    /**
     *@test
     */
    public function an_item_in_the_carts_quantity_can_be_updated()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();

        $cart->addItem($product, 1);

        $cart->update($product, 5);
        $this->assertEquals(5, $cart->quantityOf($product));
    }

    /**
     *@test
     */
    public function the_cart_may_be_queried_for_the_quantity_of_a_product()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $product3 = factory(Product::class)->create();

        $cart->addItem($product, 1);
        $cart->addItem($product2, 3);

        $this->assertEquals(1, $cart->quantityOf($product));
        $this->assertEquals(3, $cart->quantityOf($product2));
        $this->assertEquals(0, $cart->quantityOf($product3));
    }

    /**
     *@test
     */
    public function a_product_can_be_removed_from_the_cart()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $this->assertCount(1, $cart->allItems());

        $cart->remove($product);
        $this->assertCount(0, $cart->allItems());
    }

    /**
     *@test
     */
    public function the_cart_can_be_emptied()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $cart->addItem($product2, 2);
        $this->assertCount(2, $cart->allItems());

        $cart->emptyOut();
        $this->assertCount(0, $cart->allItems());
    }

    /**
     * @test
     */
    public function the_cart_can_return_the_number_of_items_as_well_as_number_of_products()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $cart->addItem($product2, 2);

        $this->assertEquals(2, $cart->totalProducts());
        $this->assertEquals(3, $cart->totalItems());
    }
}