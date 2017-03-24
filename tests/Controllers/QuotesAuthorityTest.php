<?php


use App\Products\Product;
use App\Quotes\Quote;
use App\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuotesAuthorityTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_non_super_admin_user_cannot_finalise_a_quote()
    {
        $this->asLoggedInUser([], Role::limited());

        $quote = factory(Quote::class)->create(['finalized_on' => null]);
        $quote->addItem(factory(Product::class)->create());

        $this->post('/admin/quotes/' . $quote->id . '/finalise');
        $this->assertResponseStatus(403);

        $this->assertFalse($quote->fresh()->isFinal());
    }
}