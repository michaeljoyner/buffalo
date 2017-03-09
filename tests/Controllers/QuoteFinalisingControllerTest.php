<?php


use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuoteFinalisingControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_quote_is_properly_finalised()
    {
        $quote = factory(\App\Quotes\Quote::class)->create();
        factory(\App\Quotes\QuoteItem::class)->create(['quote_id' => $quote->id]);
        $this->asLoggedInUser();

        $this->post('/admin/quotes/' . $quote->id . '/finalise')
            ->assertResponseStatus(302);

        $this->assertContains(\Carbon\Carbon::now()->format('Y-m-d'), $quote->fresh()->finalized_on);
        $this->assertTrue($quote->fresh()->isFinal());
    }

    /**
     * @test
     */
    public function a_failed_request_to_finalise_a_quote_redirects_with_error_flash_message()
    {
        //quote has no quote items, and will not be accepted
        $quote = factory(\App\Quotes\Quote::class)->create();
        $this->asLoggedInUser();

        $this->post('/admin/quotes/' . $quote->id . '/finalise')
            ->assertResponseStatus(302)
            ->assertSessionHas('flash_message', [
                'type'  => 'error',
                'title' => 'Unable to finalize quote',
                'text'  => 'Can not finalise a quote with no items',
            ])->seeInDatabase('quotes', [
                'id'           => $quote->id,
                'finalized_on' => null
            ]);

        $this->assertFalse($quote->fresh()->isFinal());
    }
}