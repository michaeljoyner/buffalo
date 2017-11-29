<?php


use App\Customers\Customer;
use App\Products\Product;
use App\Quotes\Quote;
use App\Quotes\QuoteItem;
use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuotesTest extends BrowserKitTestCase
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
        factory(QuoteItem::class)->create(['quote_id' => $quote->id]);

        $this->assertFalse($quote->isFinal());

        $quote->finalize();

        $this->assertTrue($quote->fresh()->isFinal());
    }

    /**
     *@test
     */
    public function finalising_a_quote_will_set_the_total_cost_and_selling_price_in_of_each_item()
    {
        $quote = factory(Quote::class)->create();
        $item = factory(QuoteItem::class)->create(['quote_id' => $quote->id]);

        $this->assertNull($item->total_cost);
        $this->assertNull($item->selling_price);

        $quote->finalize();

        $this->assertNotNull($item->fresh()->total_cost);
        $this->assertNotNull($item->fresh()->selling_price);
    }

    /**
     *@test
     */
    public function a_quote_with_no_items_can_not_be_finalised()
    {
        $quote = factory(Quote::class)->create();
        $this->assertCount(0, $quote->items);

        try {
            $quote->finalize();
        } catch(Exception $e) {
            $this->assertEquals('Can not finalise a quote with no items', $e->getMessage());
            return;
        }

        $this->fail('Expected exception to be thrown');
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

        $this->assertEquals($product->id, $item->product_id);
        $this->assertEquals($product->name, $item->name);
        $this->assertEquals($product->writeup, $item->description);
        $this->assertEquals($product->product_code, $item->buffalo_product_code);
        $this->assertEquals($supply->supplier->name, $item->supplier_name);
        $this->assertEquals($supply->item_number, $item->factory_number);
        $this->assertEquals($supply->currency, $item->currency);
        $this->assertEquals($supply->price, $item->factory_price);
    }

    /**
     *@test
     */
    public function adding_an_item_to_a_quote_gets_the_correct_info_from_the_product()
    {
        $quote = factory(Quote::class)->create();
        $product = factory(Product::class)->create([
            'name' => 'Acme product',
            'product_code' => 'TESTCODE123',
            'writeup' => 'Test description',
            'minimum_order_quantity' => 350,
        ]);
        factory(\App\Products\Packaging::class)->create([
            'product_id' => $product->id,
            'type' => 'Test type',
            'unit' => 'Test unit',
            'inner' => 20,
            'outer' => 100,
            'carton' => '72 inch box',
            'net_weight' => 1.2,
            'gross_weight' => 1.5
        ]);

        $item = $quote->addItem($product);

        $item = $item->fresh();

        $this->assertEquals('Acme product', $item->name);
        $this->assertEquals('TESTCODE123', $item->buffalo_product_code);
        $this->assertEquals('Test description', $item->description);
        $this->assertEquals(350, $item->moq);
        $this->assertEquals('Test type', $item->package_type);
        $this->assertEquals('Test unit', $item->package_unit);
        $this->assertEquals(20, $item->package_inner);
        $this->assertEquals(100, $item->package_outer);
        $this->assertEquals('72 inch box', $item->package_carton);
        $this->assertEquals(1.2, $item->net_weight);
        $this->assertEquals(1.5, $item->gross_weight);
    }

    /**
     *@test
     */
    public function adding_an_item_to_the_quote_gets_the_correct_supply_info()
    {
        $product = factory(Product::class)->create();
        $supply = factory(Supply::class)->create([
            'product_id' => $product->id,
            'quoted_date'   => \Carbon\Carbon::now(),
            'valid_until'   => \Carbon\Carbon::parse('+30 days'),
            'item_number'   => 'TESTCODE123',
            'currency'      => 'NTD',
            'price'         => 200,
            'package_price' => 2.5
        ]);
        $quote = factory(Quote::class)->create();

        $item = $quote->addItem($product);

        $this->assertEquals($supply->supplier->name, $item->supplier_name);
        $this->assertEquals('TESTCODE123', $item->factory_number);
        $this->assertEquals('NTD', $item->currency);
        $this->assertEquals(200, $item->factory_price);
        $this->assertEquals(2.5, $item->package_price);

    }

    /**
     *@test
     */
    public function a_quote_item_can_be_created_for_a_product_with_no_supply()
    {
        $product = factory(Product::class)->create();
        $quote = factory(Quote::class)->create();

        $item = $quote->addItem($product);

        $this->assertEquals(null, $item->supplier_name);
        $this->assertEquals(null, $item->factory_number);
        $this->assertEquals(null, $item->currency);
        $this->assertEquals(null, $item->factory_price);
        $this->assertEquals(null, $item->package_price);
    }

    /**
     *@test
     */
    public function a_quote_item_gets_its_exchange_rate_and_profit_from_the_quote_if_set()
    {
        $quote = factory(Quote::class)->create(['base_exchange_rate' => 0.77, 'base_profit' => 0.88]);
        $product = factory(Product::class)->create();

        $item = $quote->addItem($product);

        $this->assertEquals(0.77, $item->exchange_rate);
        $this->assertEquals(0.88, $item->profit);
    }

    /**
     *@test
     */
    public function a_quote_item_without_a_given_quantity_will_get_have_the_moq_of_the_product()
    {
        $quote = factory(Quote::class)->create();
        $product = factory(Product::class)->create(['minimum_order_quantity' => 447]);

        $item = $quote->addItem($product);

        $this->assertEquals(447, $item->moq);
        $this->assertEquals(447, $item->quantity);
    }

    /**
     *@test
     */
    public function a_quote_has_terms()
    {
        $quote = factory(Quote::class)->create(['terms' => 'Example terms']);

        $quote->terms = 'Updated terms';
        $quote->save();

        $this->assertEquals('Updated terms', $quote->fresh()->terms);
    }

    /**
     *@test
     */
    public function a_quote_has_a_shipment()
    {
        $quote = factory(Quote::class)->create(['shipment' => 'Across the sea']);

        $quote->shipment = 'Over the land';
        $quote->save();

        $this->assertEquals('Over the land', $quote->fresh()->shipment);
    }

    /**
     *@test
     */
    public function a_quote_has_a_quotation_remark()
    {
        $quote = factory(Quote::class)->create(['quotation_remarks' => 'Example quotation remarks']);

        $quote->quotation_remarks = 'New remarks';
        $quote->save();

        $this->assertEquals('New remarks', $quote->fresh()->quotation_remarks);
    }

    /**
     *@test
     */
    public function a_quote_has_a_base_profit_value()
    {
        $quote = factory(Quote::class)->create(['base_profit' => 0.9]);

        $quote->base_profit = 0.5;
        $quote->save();

        $this->assertEquals(0.5, $quote->fresh()->base_profit);
    }

    /**
     *@test
     */
    public function a_quote_has_a_base_exchange_rate()
    {
        $quote = factory(Quote::class)->create(['base_exchange_rate' => 0.3]);

        $quote->base_exchange_rate = 0.2;
        $quote->save();

        $this->assertEquals(0.2, $quote->fresh()->base_exchange_rate);
    }

    /**
     *@test
     */
    public function quote_item_for_the_same_product_as_existing_item_can_not_be_readded_to_quote()
    {
        $product = factory(Product::class)->create();
        $quote = factory(Quote::class)->create();

        $item = $quote->addItem($product);

        $this->assertCount(1, $quote->fresh()->items);

        $quote->addItem($product);

        $this->assertCount(1, $quote->fresh()->items);

    }

    /**
     *@test
     */
    public function a_quote_that_has_values_for_all_expected_fields_is_complete()
    {
        $incompleteCustomer = factory(Customer::class)->create(['address' => null]);
        $incompleteQuote = $this->makeQuoteWithout(['valid_until', 'shipment', 'terms']);
        $completeQuote = factory(Quote::class)->create();
        $missingCustomerData = factory(Quote::class)->create(['customer_id' => $incompleteCustomer->id]);

        $this->assertFalse($incompleteQuote->hasAllExpectedFields());
        $this->assertFalse($missingCustomerData->hasAllExpectedFields());
        $this->assertTrue($completeQuote->hasAllExpectedFields());
    }

    /**
     *@test
     */
    public function a_quote_that_does_not_have_all_expected_fields_knows_what_is_missing()
    {
        $incompleteCustomer = factory(Customer::class)->create(['address' => null]);
        $incompleteQuote = factory(Quote::class)->create([
            'customer_id' => $incompleteCustomer->id,
            'valid_until' => null,
            'shipment' => null
        ]);

        $result = $incompleteQuote->missingFields();
        $this->assertTrue(in_array('Customer address', $result));
        $this->assertTrue(in_array('Valid until', $result));
        $this->assertTrue(in_array('Shipment', $result));
    }

    /**
     *@test
     */
    public function a_quote_that_has_been_finalised_can_not_be_updated()
    {
        $quote = factory(Quote::class)->create();
        factory(QuoteItem::class)->create(['quote_id' => $quote->id]);
        $customer = factory(Customer::class)->create();
        $original_customer_id = $quote->customer->id;

        $quote->finalize();

        $quote->customer_id = $customer->id;
        $quote->save();

        $this->assertEquals($original_customer_id, $quote->fresh()->customer_id);
    }

    /**
     *@test
     */
    public function a_quote_can_cloned_for_a_new_customer()
    {
        $quote = factory(Quote::class)->create();
        factory(QuoteItem::class, 3)->create(['quote_id' => $quote->id]);
        $newCustomer = factory(Customer::class)->create();

        $newQuote = $quote->cloneFor($newCustomer);


        $this->assertEquals($newCustomer->id, $newQuote->customer_id);

        $this->assertNotEquals($quote->quote_number, $newQuote->quote_number);
        $this->assertNull($newQuote->order_id);
        $this->assertTrue($newQuote->valid_until->subDays(30)->isToday());
        $this->assertEquals($newCustomer->payment_terms, $newQuote->payment_terms);
        $this->assertEquals($newCustomer->terms, $newQuote->terms);
        $this->assertEquals($quote->remarks, $newQuote->remarks);
        $this->assertEquals($quote->quotation_remarks, $newQuote->quotation_remarks);
        $this->assertEquals($quote->shipment, $newQuote->shipment);
        $this->assertEquals($quote->base_profit, $newQuote->base_profit);
        $this->assertEquals($quote->base_exchange_rate, $newQuote->base_exchange_rate);

        $this->assertCount(3, $newQuote->items);
    }

    /**
     *@test
     */
    public function a_quote_can_copy_a_given_item_for_itself()
    {
        $item = factory(QuoteItem::class)->create();
        $newQuote = factory(Quote::class)->create();

        $newQuote->copyItem($item);
        $this->assertCount(1, $newQuote->items);
        $newItem = $newQuote->items->first();
        $this->assertEquals($item->product_id, $newItem->product_id);
        $this->assertEquals($item->buffalo_product_code, $newItem->buffalo_product_code);
        $this->assertEquals($item->supplier_name, $newItem->supplier_name);
        $this->assertEquals($item->factory_number, $newItem->factory_number);
        $this->assertEquals($item->factory_price, $newItem->factory_price);
        $this->assertEquals($item->package_price, $newItem->package_price);
        $this->assertEquals($item->additional_cost, $newItem->additional_cost);
        $this->assertEquals($item->additional_cost_memo, $newItem->additional_cost_memo);
        $this->assertEquals($item->total_cost, $newItem->total_cost);
        $this->assertEquals($item->exchange_rate, $newItem->exchange_rate);
        $this->assertEquals($item->profit, $newItem->profit);
        $this->assertEquals($item->selling_price, $newItem->selling_price);
        $this->assertEquals($item->package_type, $newItem->package_type);
        $this->assertEquals($item->package_unit, $newItem->package_unit);
        $this->assertEquals($item->package_inner, $newItem->package_inner);
        $this->assertEquals($item->package_outer, $newItem->package_outer);
        $this->assertEquals($item->package_carton, $newItem->package_carton);
        $this->assertEquals($item->net_weight, $newItem->net_weight);
        $this->assertEquals($item->gross_weight, $newItem->gross_weight);
        $this->assertEquals($item->moq, $newItem->moq);
        $this->assertEquals($item->remark, $newItem->remark);
        $this->assertEquals($item->quantity, $newItem->quantity);
    }

    protected function makeQuoteWithout($emptyFields)
    {
        $quote = factory(Quote::class)->create();

        collect($emptyFields)->each(function($field) use ($quote) {
            $quote->{$field} = null;
        });

        $quote->save();

        return $quote;
    }
}