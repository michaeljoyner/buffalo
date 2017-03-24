<?php


use App\Presenters\QuoteItemPresenter;
use App\Presenters\QuotePresenter;
use App\Quotes\Quote;
use App\Quotes\QuoteItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuotePresenterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_quote_can_be_made_presentable()
    {
        $quote = $this->makeFinalizedQuote();

        $presenter = $quote->present(QuotePresenter::class);

        $this->assertInstanceOf(QuotePresenter::class, $presenter);
    }

    /**
     *@test
     */
    public function a_presented_quote_presents_presentable_items()
    {
        $quote = $this->makeFinalizedQuote(3);

        $presenter = $quote->present(QuotePresenter::class);

        $items = $presenter->items;

        $this->assertCount(3, $items);

        $items->each(function($item) {
            $this->assertInstanceOf(QuoteItemPresenter::class, $item);
        });
    }

    /**
     *@test
     */
    public function it_presents_the_customer_name()
    {
        $customer = factory(\App\Customers\Customer::class)->create(['name' => 'Corporate Example']);
        $quote = $this->makePresenterForQuote(['customer_id' => $customer->id]);

        $this->assertEquals('Company: Corporate Example', $quote->customer_name);
    }

    /**
     * @test
     */
    public function it_presents_the_customer_address()
    {
        $customer = factory(\App\Customers\Customer::class)->create(['address' => '123 Sesame Street']);
        $quote = $this->makePresenterForQuote(['customer_id' => $customer->id]);

        $this->assertEquals("Address:\n123 Sesame Street", $quote->customer_address);
    }

    /**
     *@test
     */
    public function it_presents_the_contact_person_field()
    {
        $customer = factory(\App\Customers\Customer::class)->create(['contact_person' => 'Joe Soap']);
        $quote = $this->makePresenterForQuote(['customer_id' => $customer->id]);

        $this->assertEquals('Attn: Joe Soap', $quote->contact_person);
    }

    /**
     *@test
     */
    public function it_presents_the_valid_until_date()
    {
        $quote = $this->makePresenterForQuote(['valid_until' => \Carbon\Carbon::parse('+30 days')]);

        $this->assertEquals('Validity: By ' . \Carbon\Carbon::parse('+30 days')->toFormattedDateString(), $quote->validity);
    }

    /**
     *@test
     */
    public function it_presents_the_payment_terms_info()
    {
        $quote = $this->makePresenterForQuote(['payment_terms' => '30 days later']);

        $this->assertEquals('Payment terms: 30 days later', $quote->payment_terms);
    }

    /**
     *@test
     */
    public function it_presents_the_shipment_info()
    {
        $quote = $this->makePresenterForQuote(['shipment' => 'After example payment']);

        $this->assertEquals('Shipment: After example payment', $quote->shipment);
    }

    /**
     *@test
     */
    public function it_presents_the_terms()
    {
        $quote = $this->makePresenterForQuote(['terms' => 'Till tests do us part']);

        $this->assertEquals('Terms: Till tests do us part', $quote->terms);
    }

    /**
     *@test
     */
    public function it_presents_the_quoting_date()
    {
        $quote = $this->makePresenterForQuote();

        $this->assertEquals('Date: ' . \Carbon\Carbon::now()->toFormattedDateString(), $quote->quote_date);
    }

    /**
     *@test
     */
    public function it_presents_the_quote_number()
    {
        $quote = $this->makePresenterForQuote();

        $this->assertContains('Ref: ', $quote->quote_number);
    }

    /**
     *@test
     */
    public function it_presents_the_address_height()
    {
        $threeLines = "123 sesame street\nNew York\nUSA";
        $customer = factory(\App\Customers\Customer::class)->create(['address' => $threeLines]);
        $quote = $this->makePresenterForQuote(['customer_id' => $customer->id]);
        //20px for label, 20px for each line plus 10 extra
        $this->assertEquals(90, $quote->address_height);
    }

    /**
     *@test
     */
    public function it_presents_the_remarks_height()
    {
        $fourLines = "Line one\nLine two\nLine three\nLine four";
        $quote = $this->makePresenterForQuote(['quotation_remarks' => $fourLines]);
        //20px for each line plus 10px extra
        $this->assertEquals(90, $quote->remarks_height);
    }

    protected function makePresenterForQuote($attributes = [])
    {
        $quote = factory(Quote::class)->create($attributes);
        factory(QuoteItem::class)->create(['quote_id' => $quote->id]);
        $quote->finalize();

        return $quote->present(QuotePresenter::class);
    }

    protected function makeFinalizedQuote($noOfItems = 1)
    {
        $quote = factory(Quote::class)->create();
        factory(QuoteItem::class, $noOfItems)->create(['quote_id' => $quote->id]);
        $quote->finalize();

        return $quote->fresh();
    }


}