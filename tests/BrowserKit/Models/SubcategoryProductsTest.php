<?php
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/26/16
 * Time: 9:27 AM
 */
class SubcategoryProductsTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_can_be_added_to_a_subcategory_by_posting_form()
    {
        $subcategory = factory(Subcategory::class)->create();
        $this->asLoggedInUser();

        Session::start();
        $response = $this->call('POST', '/admin/subcategories/' . $subcategory->id . '/products', [
            'name' => 'Monkey Wrench',
            'product_code' => 'abcde123',
            'description' => 'An instant classic',
            '_token' => csrf_token()
        ]);
        $this->assertRedirectResponse($response);

        $this->seeInDatabase('products', [
            'category_id' => $subcategory->category->id,
            'subcategory_id' => $subcategory->id,
            'name' => 'Monkey Wrench',
            'product_code' => 'abcde123',
            'description' => 'An instant classic',
        ]);
    }
}