<?php


use App\Customers\Customer;
use App\Products\Product;
use App\Quotes\Quote;
use App\Quotes\QuotesRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuoteRepositoryTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    private $repo;

    public function setUp()
    {
        parent::setUp();

        $this->repo = new QuotesRepository();
    }

    /**
     *@test
     */
    public function it_can_fetch_quotes_for_a_given_customer()
    {
        $customer = factory(Customer::class)->create();
        factory(Quote::class, 2)->create(['customer_id' => $customer->id]);
        $nonCustomerQuotes = factory(Quote::class, 2)->create();

        $result = $this->repo->forCustomer($customer);

        $this->assertCount(2, $result);
        $nonCustomerQuotes->each(function($quote) use ($result) {
            $this->assertFalse(in_array($quote->id, $result->pluck('id')->toArray()));
        });
    }

    /**
     *@test
     */
    public function it_can_fetch_quotes_containing_a_given_product()
    {
        $product = factory(Product::class)->create();
        $quotes = factory(Quote::class, 5)->create();

        $quotes->each(function($quote, $index) use ($product) {
            if($index === 2 || $index === 4) {
                $quote->addItem($product);
            } else {
                $quote->addItem(factory(Product::class)->create());
            }
        });

        $result = $this->repo->byProduct($product);

        $this->assertCount(2, $result);
        $result->each(function($quote) use ($product) {
            $this->assertTrue(in_array($product->id, $quote->items->pluck('product_id')->toArray()));
        });
    }

    /**
     *@test
     */
    public function quotes_for_a_given_customer_and_containing_a_given_product_can_be_searched()
    {
        //make quote with known customer and product
        $customer = factory(Customer::class)->create();
        $product = factory(Product::class)->create();
        $quote = factory(Quote::class)->create(['customer_id' => $customer->id]);
        $quote->addItem($product);
        //quote with customer but not product
        factory(Quote::class)->create(['customer_id' => $customer->id]);
        //quote with product but not customer
        factory(Quote::class)->create()->addItem($product);
        //quote with neither customer nor product
        factory(Quote::class)->create();

        $result = $this->repo->forCustomerWithProduct($customer, $product);

        $this->assertCount(1, $result);
        $this->assertEquals($result->first()->id, $quote->id);

    }
}