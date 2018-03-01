<?php
use App\Orders\Order;
use App\Products\Product;
use App\Shopping\ShoppingCart;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class CheckoutControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function posting_a_valid_order_form_to_checkout_admin_completes_an_order()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $cart->addItem($product2, 2);

        $formFields = [
            'company'        => 'Acme company',
            'contact_person' => 'Mc Hammer',
            'phone'          => '0123456789',
            'fax'            => '9876543210',
            'email'          => 'joe@example.com',
            'website'        => 'totesacme.com',
            'referrer'       => 'google',
            'requirements'   => '3 bags of wool'
        ];

        $response = $this->call('POST', '/checkout', $formFields);
        $this->assertRedirectResponse($response);

        $this->seeInDatabase('orders', $formFields);

        $this->seeInDatabase('order_items', [
            'product_id' => $product->id,
            'name' => $product->name,
            'quantity' => 1
        ]);

        $this->seeInDatabase('order_items', [
            'product_id' => $product2->id,
            'name' => $product2->name,
            'quantity' => 2
        ]);
    }

    /**
     *@test
     */
    public function an_order_can_still_be_placed_with_only_the_required_fields()
    {
        \Illuminate\Support\Facades\Mail::fake();
        $this->disableExceptionHandling();

        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $cart->addItem($product2, 2);

        $formFields = [
            'company'        => 'Acme company',
            'contact_person' => 'Mc Hammer',
            'email'          => 'joe@example.com',
        ];

        $response = $this->call('POST', '/checkout', $formFields);
        $this->assertRedirectResponse($response);

        $this->seeInDatabase('orders', $formFields);

        $this->seeInDatabase('order_items', [
            'product_id' => $product->id,
            'name' => $product->name,
            'quantity' => 1
        ]);

        $this->seeInDatabase('order_items', [
            'product_id' => $product2->id,
            'name' => $product2->name,
            'quantity' => 2
        ]);

        $this->assertCount(0, $cart->allItems());
    }

    /**
     *@test
     */
    public function an_order_will_not_be_created_if_the_posted_fields_are_invalid()
    {
        $cart = $this->app->make(ShoppingCart::class);
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $cart->addItem($product, 1);
        $cart->addItem($product2, 2);

        $formFields = [
            'company'        => 'Acme company',
            'contact_person' => 'Mc Hammer',
            'email'          => 'not an email',
        ];

        $response = $this->call('POST', '/checkout', $formFields);
        $this->assertRedirectResponse($response);

        $this->assertCount(0, Order::where('company', 'Acme company')->get());
    }
}