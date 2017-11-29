<?php
use App\Products\Category;
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/1/16
 * Time: 10:21 AM
 */
class SubcategoriesControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_subcategory_can_be_created_by_posting_to_an_endpoint()
    {
        $category = factory(Category::class)->create();
        $this->asLoggedInUser();

        $response = $this->call('POST', '/admin/categories/' . $category->id . '/subcategories', [
            'name'        => 'Weavels and Beavels',
            'description' => 'probably not tools'
        ]);
        $this->assertRedirectResponse($response);

        $this->seeInDatabase('subcategories', [
            'id'          => $category->id,
            'name'        => 'Weavels and Beavels',
            'description' => 'probably not tools'
        ]);
    }

    /**
     *@test
     */
    public function a_subcategories_name_and_description_can_be_edited()
    {
        $subcategory = factory(Subcategory::class)->create();
        $this->asLoggedInUser();

        $this->visit('/admin/subcategories/' . $subcategory->id . '/edit')
            ->type('A new name', 'name')
            ->type('A new description', 'description')
            ->press('Save Changes')
            ->seeInDatabase('subcategories', [
                'id' => $subcategory->id,
                'name' => 'A new name',
                'description' => 'A new description'
            ]);
    }

    /**
     *@test
     */
    public function a_subcategory_can_be_soft_deleted()
    {
        $subcategory = factory(Subcategory::class)->create();
        $this->asLoggedInUser();

        $response = $this->call('DELETE', '/admin/subcategories/' . $subcategory->id);
        $this->assertRedirectResponse($response);

        $this->assertSoftDeleted($subcategory);
    }
}