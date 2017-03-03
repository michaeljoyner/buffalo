<?php


use App\Quotes\Quote;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuotesControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_quotes_non_item_info_is_correctly_updated()
    {
        $quote = factory(Quote::class)->create();
        $this->asLoggedInUser();

        $this->post('/admin/quotes/' . $quote->id, [
            'quote_number' => 'XXX_test20170303',
            'valid_until' => \Carbon\Carbon::parse('+1 month')->format('Y-m-d'),
            'payment_terms' => '30 days, no quibble',
            'terms' => 'Easy on, no rush',
            'remarks' => 'What a lovely day',
            'quotation_remarks' => 'You better pay us for this',
            'shipment' => 'We ship it on a ship',
            'base_profit' => 0.8,
            'base_exchange_rate' => 0.3
        ])->assertResponseStatus(302)
            ->seeInDatabase('quotes', [
                'id' => $quote->id,
                'quote_number' => 'XXX_test20170303',
                'valid_until' => \Carbon\Carbon::parse('+1 month')->format('Y-m-d') . ' 00:00:00',
                'remarks' => 'What a lovely day',
                'payment_terms' => '30 days, no quibble',
                'terms' => 'Easy on, no rush',
                'quotation_remarks' => 'You better pay us for this',
                'shipment' => 'We ship it on a ship',
                'base_profit' => 0.8,
                'base_exchange_rate' => 0.3
            ]);
    }

    /**
     *@test
     */
    public function a_quote_can_be_deleted()
    {
        $quote = factory(Quote::class)->create();
        $this->asLoggedInUser();

        $this->delete('/admin/quotes/' . $quote->id)
            ->assertResponseStatus(302)
            ->notSeeInDatabase('quotes', ['id' => $quote->id]);
    }
}