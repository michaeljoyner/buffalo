<?php
use App\Products\Category;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/26/16
 * Time: 9:08 AM
 */
class CategoryProductsControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_can_be_created_for_a_category_by_posting_form()
    {
        $category = factory(Category::class)->create();
        $this->asLoggedInUser();

        Session::start();
        $response = $this->call('POST', '/admin/categories/' . $category->id . '/products', [
            'name' => 'Monkey Wrench',
            'product_code' => 'abcde123',
            'description' => 'An instant classic',
            '_token' => csrf_token()
        ]);
        $this->assertRedirectResponse($response);

        $this->seeInDatabase('products', [
            'category_id' => $category->id,
            'name' => 'Monkey Wrench',
            'product_code' => 'abcde123',
            'description' => 'An instant classic',
        ]);
    }

    /**
     *@test
     */
    public function a_product_cannot_be_created_with_a_non_unique_product_code()
    {
        $original = factory(Product::class)->create();
        $category = factory(Category::class)->create();

        $this->asLoggedInUser();
        Session::start();
        $response = $this->call('POST', '/admin/categories/' . $category->id . '/products', [
            'name' => 'Monkey Wrench',
            'product_code' => $original->product_code,
            'description' => 'An instant classic',
            '_token' => csrf_token()
        ]);
        $this->assertRedirectResponse($response);

        $this->notSeeInDatabase('products', [
            'category_id' => $category->id,
            'name' => 'Monkey Wrench',
            'description' => 'An instant classic',
        ]);
    }
}