<?php


use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuotesControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_quotes_non_item_info_is_correctly_updated()
    {
        $quote = factory(\App\Quotes\Quote::class)->create();
        $this->asLoggedInUser();

        $this->post('/admin/quotes/' . $quote->id, [
            'valid_until' => \Carbon\Carbon::parse('+1 month')->format('Y-m-d'),
            'payment_terms' => '30 days, no quibble',
            'remarks' => 'What a lovely day'
        ])->assertResponseStatus(302)
            ->seeInDatabase('quotes', [
                'id' => $quote->id,
                'valid_until' => \Carbon\Carbon::parse('+1 month')->format('Y-m-d') . ' 00:00:00',
                'remarks' => 'What a lovely day'
            ]);
    }
}