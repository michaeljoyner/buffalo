<?php


use App\Products\Product;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductNotesTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_note_can_be_created_for_a_product_and_is_given_a_user()
    {
        $user = $this->asLoggedInUser();
        $product = factory(Product::class)->create();

        $note = $product->setNote('Notes are the bees knees', $user);

        $this->assertInstanceOf(App\Products\ProductNote::class, $note);
        $this->assertEquals('Notes are the bees knees', $note->content);
        $this->assertEquals($user->id, $note->author->id);
    }

    /**
     *@test
     */
    public function a_products_note_can_be_cleared_aka_deleted()
    {
        $user = $this->asLoggedInUser();
        $product = factory(Product::class)->create();
        $product->setNote('Notes are the bees knees', $user);
        $product = $product->fresh();

        $product->clearNote();
        $product = $product->fresh();

        $this->assertNull($product->note);
    }

    /**
     *@test
     */
    public function a_product_note_set_when_a_note_already_exists_updates_the_note_not_creates_a_new_one()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $product->setNote('Note one', $user);
        $product = $product->fresh();
        $product->setNote('Note two', $user);

        $this->assertCount(1, \App\Products\ProductNote::all());
        $this->assertEquals('Note two', $product->getNote());
    }

    /**
     *@test
     */
    public function setting_a_note_with_the_same_content_does_not_update_the_user()
    {
        $user = factory(User::class)->create();
        $user2 = $this->asLoggedInUser();
        $product = factory(Product::class)->create();

        $product->setNote('This is a note', $user);
        $product = $product->fresh();

        $product->setNote('This is a note', $user2);
        $product = $product->fresh();

        $this->assertEquals($user->id, $product->note->author->id);
    }

    /**
     *@test
     */
    public function a_new_note_from_a_different_user_does_update_the_author()
    {
        $user = factory(User::class)->create();
        $user2 = $this->asLoggedInUser();
        $product = factory(Product::class)->create();

        $product->setNote('This is a note', $user);
        $product = $product->fresh();

        $product->setNote('This is a new note', $user2);
        $product = $product->fresh();

        $this->assertEquals($user2->id, $product->note->author->id);
        $this->assertEquals('This is a new note', $product->getNote());
    }
}