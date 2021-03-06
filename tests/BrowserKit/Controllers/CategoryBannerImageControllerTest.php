<?php


use App\Products\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryBannerImageControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function an_uploaded_image_is_correctly_stored_as_the_category_banner()
    {
        $this->disableExceptionHandling();
        $this->asLoggedInUser();
        $category = factory(Category::class)->create();

        $response = $this->call('POST', '/admin/categories/' . $category->id . '/banner/image', [], [], [
            'file' => \Illuminate\Http\UploadedFile::fake()->image('testpic.png')
        ]);
        $this->assertEquals(200, $response->status());
        $category = $category->fresh();
        $this->assertCount(1, $category->bannerImage->getMedia());
        $category->bannerImage->clearMediaCollection();
    }
}