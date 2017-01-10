<?php
use App\Products\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/31/16
 * Time: 9:35 AM
 */
class CategoriesControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_category_can_be_created_by_posting_to_endpoint()
    {
        $this->asLoggedInUser();
        Session::start();

        $response = $this->call('POST', '/admin/categories', [
            'name'        => 'Power Tools',
            'description' => 'The most powerful tools',
            '_token'      => csrf_token()
        ]);

        $this->assertRedirectResponse($response);

        $this->seeInDatabase('categories', [
            'name'        => 'Power Tools',
            'description' => 'The most powerful tools'
        ]);
    }

    /**
     * @test
     */
    public function a_category_name_and_description_can_be_edited()
    {
        $category = factory(Category::class)->create();
        $this->asLoggedInUser();

        $this->visit('/admin/categories/' . $category->id . '/edit')
            ->type('Power Tools updated', 'name')
            ->type('A description interrupted', 'description')
            ->press('Save Changes')
            ->seeInDatabase('categories', [
                'id'          => $category->id,
                'name'        => 'Power Tools updated',
                'description' => 'A description interrupted'
            ]);
    }

    /**
     * @test
     */
    public function a_category_can_be_soft_deleted()
    {
        $category = factory(Category::class)->create();
        $this->asLoggedInUser();
        Session::start();

        $response = $this->call('DELETE', '/admin/categories/' . $category->id, ['_token' => csrf_token()]);
        $this->assertRedirectResponse($response);

        $this->assertSoftDeleted($category);
    }
}