<?php
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/26/16
 * Time: 8:55 AM
 */
class ProductsControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_products_name_description_code_and_writeup_may_be_edited()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();

        $this->visit('/admin/products/' . $product->id . '/edit')
            ->type('Zions Hammer', 'name')
            ->type('newCODE', 'product_code')
            ->type('600', 'minimum_order_quantity')
            ->type('Hammer, hammer, hammer, you down', 'description')
            ->type('A catchy tune', 'writeup')
            ->press('Save Changes')
            ->seeInDatabase('products', [
                'id'           => $product->id,
                'name'         => 'Zions Hammer',
                'product_code' => 'newCODE',
                'description'  => 'Hammer, hammer, hammer, you down',
                'writeup'      => 'A catchy tune',
                'minimum_order_quantity' => 600
            ]);
    }

    /**
     * @test
     */
    public function a_product_with_a_note_has_the_note_correctly_updated()
    {
        $user = $this->asLoggedInUser();
        $product = factory(Product::class)->create();
        $product->setNote('Notify this', $user);

        $this->post('/admin/products/' . $product->id, [
            'name'         => $product->name,
            'product_code' => $product->product_code,
            'description'  => $product->description,
            'writeup'      => $product->writeup,
            'product_note' => 'This is a whole new note'
        ])->assertResponseStatus(302)
            ->seeInDatabase('products', [
                'name'         => $product->name,
                'product_code' => $product->product_code,
                'description'  => $product->description,
                'writeup'      => $product->writeup
            ])
            ->seeInDatabase('product_notes', [
                'product_id' => $product->id,
                'user_id'    => $user->id,
                'content'    => 'This is a whole new note'
            ]);
    }

    /**
     * @test
     */
    public function a_product_with_an_existing_note_and_no_product_note_on_update_request_has_note_deleted()
    {
        $user = $this->asLoggedInUser();
        $product = factory(Product::class)->create();
        $product->setNote('Notify this', $user);

        $this->post('/admin/products/' . $product->id, [
            'name'         => $product->name,
            'product_code' => $product->product_code,
            'description'  => $product->description,
            'writeup'      => $product->writeup,
            'product_note' => ''
        ])->assertResponseStatus(302)
            ->seeInDatabase('products', [
                'name'         => $product->name,
                'product_code' => $product->product_code,
                'description'  => $product->description,
                'writeup'      => $product->writeup
            ])
            ->notSeeInDatabase('product_notes', [
                'product_id' => $product->id,
            ]);

        $product = $product->fresh();
        $this->assertNull($product->note);
    }

    /**
     * @test
     */
    public function a_product_can_be_soft_deleted()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();
        Session::start();

        $response = $this->call('DELETE', '/admin/products/' . $product->id, ['_token' => csrf_token()]);
        $this->assertRedirectResponse($response);

        $this->assertSoftDeleted($product);
    }

    /**
     * @test
     */
    public function a_product_cannot_be_created_with_a_non_unique_product_code()
    {
        $product = factory(Product::class)->create(['product_code' => '123abc']);
        $this->asLoggedInUser();

        $this->post('/admin/categories/' . $product->category->id . '/products', [
            'name'         => 'Product A',
            'product_code' => '123abc',
            'description'  => 'A product'
        ])->assertResponseStatus(302)
            ->assertSessionHasErrors()
            ->notSeeInDatabase('products', ['name' => 'Product A']);
    }

    /**
     *@test
     */
    public function a_product_can_be_created_if_it_has_the_same_product_code_as_a_soft_deleted_product()
    {
        $product = factory(Product::class)->create(['product_code' => '123abc', 'deleted_at' => \Carbon\Carbon::now()]);
        $this->asLoggedInUser();

        $this->post('/admin/categories/' . $product->category->id . '/products', [
            'name'         => 'Product A',
            'product_code' => '123abc',
            'description'  => 'A product'
        ])->assertResponseStatus(302)
            ->seeInDatabase('products', ['name' => 'Product A']);
    }
}