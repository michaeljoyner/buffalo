<?php


use App\Quotes\Quote;
use App\Quotes\QuoteItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuoteCompletenessControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;
    /**
     *@test
     */
    public function a_report_on_a_given_quotes_state_of_completeness_can_be_fetched()
    {
        $quote = factory(Quote::class)->create();
        factory(QuoteItem::class, 3)->create(['quote_id' => $quote->id]);
        $this->asLoggedInUser();
        $this->get('/admin/quotes/' . $quote->id . '/completeness')
            ->assertResponseOk()
            ->seeJson([
                'hasAllExpectedFields' => true,
                'missingFields' => [],
            ]);

        $result = $this->readJson();

        $this->assertCount(3, $result['items']);
        collect($result['items'])->each(function($item) {
            $this->assertEquals(QuoteItem::FULLY_COMPLETE, $item['completeness_level']);
        });
    }

    /**
     * @test
     */
    public function a_correct_report_is_given_for_an_incomplete_quote()
    {
        $customer = factory(\App\Customers\Customer::class)->create(['address' => null]);
        $quote = factory(Quote::class)->create([
            'customer_id' => $customer->id,
            'shipment' => null,
            'terms' => null
        ]);
        $item1 = factory(QuoteItem::class)->create([
            'quote_id' => $quote->id,
            'profit'               => null,
            'moq'                  => null,
            'remark'               => null,
            'package_type'         => null,
            'package_unit'         => null,
            'package_inner'        => null,
            'package_outer'        => null,
        ]);
        $item2 = factory(QuoteItem::class)->create([
            'quote_id' => $quote->id,
            'remark'               => null,
        ]);

        $this->asLoggedInUser();

        $this->get('/admin/quotes/' . $quote->id . '/completeness')
            ->assertResponseOk()
            ->seeJson([
                'hasAllExpectedFields' => false,
                'missingFields' => ['Customer address', 'Shipment', 'Terms'],
            ]);

        $result = $this->readJson();

        $this->assertCount(2, $result['items']);

        $this->assertTrue(collect($result['items'])->contains(['name' => $item1->name, 'id' => $item1->id, 'completeness_level' => QuoteItem::LESS_THAN_ALMOST_COMPLETE]));
        $this->assertTrue(collect($result['items'])->contains(['name' => $item2->name, 'id' => $item2->id, 'completeness_level' => QuoteItem::ALMOST_COMPLETE]));

    }

}