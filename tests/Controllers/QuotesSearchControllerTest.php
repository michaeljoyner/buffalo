<?php


use App\Customers\Customer;
use App\Products\Product;
use App\Quotes\Quote;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuotesSearchControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_search_by_customer_can_be_performed()
    {
        $customer = factory(Customer::class)->create();
        $quote = factory(Quote::class)->create(['customer_id' => $customer->id]);
        $this->asLoggedInUser();

        $this->visit('/admin/quotes-search/customers/' . $customer->id)
            ->seePageIs('/admin/quotes-search/customers/' . $customer->id)
            ->see($quote->quote_number);
    }

    /**
     *@test
     */
    public function a_search_by_product_can_be_performed()
    {
        $product = factory(Product::class)->create();
        $quote = factory(Quote::class)->create();
        $quote->addItem($product);
        $this->asLoggedInUser();

        $this->visit('/admin/quotes-search/products/' . $product->id)
            ->seePageIs('/admin/quotes-search/products/' . $product->id)
            ->see($quote->quote_number);
    }

    /**
     *@test
     */
    public function a_search_by_product_and_customer_can_be_performed()
    {
        $customer = factory(Customer::class)->create();
        $product = factory(Product::class)->create();
        $quote = factory(Quote::class)->create(['customer_id' => $customer->id]);
        $quote->addItem($product);
        $this->asLoggedInUser();

        $this->visit('/admin/quotes-search/customers/' . $customer->id . '/products/' . $product->id)
            ->seePageIs('/admin/quotes-search/customers/' . $customer->id . '/products/' . $product->id)
            ->see($quote->quote_number);
    }
}