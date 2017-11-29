<?php


use App\Products\Product;
use App\Quotes\Quote;
use App\Quotes\QuoteItem;
use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuoteItemsControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function multiple_quote_items_are_correctly_stored_on_the_quote()
    {
        $this->disableExceptionHandling();
        $quote = factory(Quote::class)->create();
        $products = factory(Product::class, 5)->create();
        $this->asLoggedInUser();

        $this->post('/admin/quotes/' . $quote->id . '/items', [
            'product_ids' => $products->pluck('id')->toArray()
        ])->assertResponseStatus(201);

        $products->each(function($product) use ($quote) {
            $this->seeInDatabase('quote_items', ['product_id' => $product->id, 'quote_id' => $quote->id]);
        });
    }

    /**
     * @test
     */
    public function the_items_for_a_given_quote_may_be_fetched()
    {
        $product = factory(Product::class)->create();
        $productB = factory(Product::class)->create();
        $supply = factory(Supply::class)->create(['product_id' => $product->id]);
        $quote = factory(Quote::class)->create();
        $quote->addItem($product, 10, $supply);
        $quote->addItem($productB);

        $this->asLoggedInUser();
        $this->get('/admin/quotes/' . $quote->id . '/items')
            ->assertResponseOk()
            ->seeJsonForQuoteItem($product, 10, $supply)
            ->seeJsonForQuoteItem($productB);
    }

    /**
     * @test
     */
    public function a_quote_item_is_correctly_updated()
    {
        $item = factory(QuoteItem::class)->create();
        $this->asLoggedInUser();

        $this->patch('/admin/quoteitems/' . $item->id, [
            'factory_price'  => '98989.89',
            'currency'       => 'JPY',
            'factory_number' => null,
        ])->assertResponseOk()
            ->seeInDatabase('quote_items', [
                'quote_id'             => $item->quote_id,
                'product_id'           => $item->product_id,
                'name'                 => $item->name,
                'buffalo_product_code' => $item->buffalo_product_code,
                'supplier_name'        => $item->supplier_name,
                'factory_number'       => $item->factory_number,
                'currency'             => 'JPY',
                'factory_price'        => 98989.89,
                'additional_cost'      => $item->additional_cost,
                'exchange_rate'        => $item->exchange_rate,
                'quantity'             => $item->quantity,
                'description'          => $item->description
            ]);
    }

    /**
     * @test
     */
    public function patching_a_quote_item_will_not_update_null_values_but_will_update_empty_strings()
    {
        $item = factory(QuoteItem::class)->create();
        $this->asLoggedInUser();

        $this->patch('/admin/quoteitems/' . $item->id, [
            'factory_price'  => '98989.89',
            'currency'       => 'JPY',
            'factory_number' => null,
            'supplier_name'  => '',
            'description'    => '',
            'name'           => null
        ])->assertResponseOk()
            ->seeInDatabase('quote_items', [
                'quote_id'             => $item->quote_id,
                'product_id'           => $item->product_id,
                'name'                 => $item->name,
                'buffalo_product_code' => $item->buffalo_product_code,
                'supplier_name'        => '',
                'factory_number'       => $item->factory_number,
                'currency'             => 'JPY',
                'factory_price'        => 98989.89,
                'additional_cost'      => $item->additional_cost,
                'exchange_rate'        => $item->exchange_rate,
                'quantity'             => $item->quantity,
                'description'          => ''
            ]);
    }

    /**
     *@test
     */
    public function a_quote_item_is_properly_deleted()
    {
        $item = factory(QuoteItem::class)->create();
        $this->asLoggedInUser();

        $this->delete('/admin/quoteitems/' . $item->id)
            ->assertResponseOk()
            ->notSeeInDatabase('quote_items', ['id' => $item->id]);
    }

    protected function seeJsonForQuoteItem($product, $quantity = 1, $supply = null)
    {
        $this->seeJson([
            'name'                 => $product->name,
            'description'          => $product->writeup,
            'buffalo_product_code' => $product->product_code,
            'quantity'             => $quantity,
            'supplier_name'        => $supply->supplier->name ?? null,
            'factory_number'       => $supply->item_number ?? null,
            'currency'             => $supply->currency ?? null,
        ]);

        return $this;
    }
}