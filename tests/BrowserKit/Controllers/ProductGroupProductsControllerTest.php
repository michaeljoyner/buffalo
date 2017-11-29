<?php
use App\Products\ProductGroup;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/26/16
 * Time: 9:42 AM
 */
class ProductGroupProductsControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_product_can_be_added_to_a_product_group_by_posting_a_form()
    {
        $productGroup = factory(ProductGroup::class)->create();
        $this->asLoggedInUser();
        Session::start();

        $response = $this->call('POST', '/admin/productgroups/' . $productGroup->id . '/products', [
            'name'         => 'Monkey Wrench',
            'product_code' => 'abcde123',
            'description'  => 'An instant classic',
            '_token'       => csrf_token()
        ]);
        $this->assertRedirectResponse($response);

        $this->seeInDatabase('products', [
            'category_id'      => $productGroup->subcategory->category->id,
            'subcategory_id'   => $productGroup->subcategory->id,
            'product_group_id' => $productGroup->id,
            'name'             => 'Monkey Wrench',
            'product_code'     => 'abcde123',
            'description'      => 'An instant classic',
        ]);
    }
}