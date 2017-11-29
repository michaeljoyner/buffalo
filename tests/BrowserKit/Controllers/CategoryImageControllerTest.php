<?php
use App\Products\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/31/16
 * Time: 11:43 AM
 */
class CategoryImageControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function an_image_can_be_uploaded_for_a_given_category()
    {
        $category = factory(Category::class)->create();
        $this->asLoggedInUser();

        $response = $this->call('POST', '/admin/categories/' . $category->id . '/image', [], [], [
            'file' => $this->prepareFileUpload('tests/testpic1.png')
        ]);
        $this->assertOkResponse($response);

        $this->assertCount(1, $category->getMedia());
        $category->clearMediaCollection();
    }
}