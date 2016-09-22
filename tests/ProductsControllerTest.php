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
     *@test
     */
    public function a_products_name_description_code_and_writeup_may_be_edited()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();

        $this->visit('/admin/products/'.$product->id.'/edit')
            ->type('Zions Hammer', 'name')
            ->type('newCODE', 'product_code')
            ->type('Hammer, hammer, hammer, you down', 'description')
            ->type('A catchy tune', 'writeup')
            ->press('Save Changes')
            ->seeInDatabase('products', [
                'id' => $product->id,
                'name' => 'Zions Hammer',
                'product_code' => 'newCODE',
                'description' => 'Hammer, hammer, hammer, you down',
                'writeup' => 'A catchy tune'
            ]);
    }

    /**
     *@test
     */
    public function a_product_can_be_soft_deleted()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();
        Session::start();

        $response = $this->call('DELETE', '/admin/products/'.$product->id, ['_token' => csrf_token()]);
        $this->assertRedirectResponse($response);

        $this->assertSoftDeleted($product);
    }
}