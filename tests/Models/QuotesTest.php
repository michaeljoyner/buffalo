<?php


use App\Products\Product;
use App\Quotes\Quote;
use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuotesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function it_can_add_an_item_based_on_a_order_item()
    {
        $product = factory(Product::class)->create();
        $order = factory(\App\Orders\Order::class)->create();
        $item = $order->addItem($product, 10);
        $quote = factory(Quote::class)->create();

        $quote->addItemFromOrder($item);

        $quoteItem = $quote->fresh()->items->first();

        $this->assertEquals($item->product_id, $quoteItem->product_id);
        $this->assertEquals(10, $quoteItem->quantity);
        $this->assertEquals($item->name, $quoteItem->name);
        $this->assertEquals($item->product->product_code, $quoteItem->buffalo_product_code);

    }

    /**
     *@test
     */
    public function deleting_a_quote_deletes_all_its_items()
    {
        $product = factory(Product::class)->create();
        $order = factory(\App\Orders\Order::class)->create();
        $item = $order->addItem($product, 10);
        $quote = factory(Quote::class)->create();

        $quoteItem = $quote->addItemFromOrder($item);

        $quote->delete();

        $this->notSeeInDatabase('quotes', ['id' => $quote->id]);
        $this->notSeeInDatabase('quote_items', ['id' => $quoteItem->id]);
    }

    /**
     *@test
     */
    public function a_quote_is_automatically_given_a_quote_number_when_created()
    {
        $quote = factory(Quote::class)->create();
        $timestring = \Carbon\Carbon::now()->format('Ymd');
        $this->assertRegExp('/[A-Z0-9]{3}_' . $timestring . '/', $quote->quote_number);
    }

    /**
     *@test
     */
    public function a_quote_may_be_finalised()
    {
        $quote = factory(Quote::class)->create(['finalized_on' => null]);

        $this->assertFalse($quote->isFinal());

        $quote->finalize();

        $this->assertTrue($quote->fresh()->isFinal());
    }

    /**
     *@test
     */
    public function an_item_can_be_added_to_a_quote()
    {
        $product = factory(Product::class)->create();
        $supply = factory(Supply::class)->create(['product_id' => $product->id]);
        $quote = factory(Quote::class)->create();

        $item = $quote->addItem($product, 1, $supply);

//        dd($item);

        $this->assertEquals($product->id, $item->product_id);
        $this->assertEquals($product->name, $item->name);
        $this->assertEquals($product->writeup, $item->description);
        $this->assertEquals($product->product_code, $item->buffalo_product_code);
        $this->assertEquals($supply->supplier->name, $item->supplier_name);
        $this->assertEquals($supply->item_number, $item->factory_number);
        $this->assertEquals($supply->currency, $item->currency);
        $this->assertEquals($supply->price, $item->factory_price);
    }
}