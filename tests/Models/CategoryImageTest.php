<?php
use App\Products\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/31/16
 * Time: 11:06 AM
 */
class CategoryImageTest extends TestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function an_image_can_be_set_for_a_category()
    {
        $category = factory(Category::class)->create();
        $category->setImage($this->prepareFileUpload('tests/testpic1.png'));

        $this->assertCount(1, $category->getMedia());
        $category->clearMediaCollection();
    }

    /**
     *@test
     */
    public function a_category_has_at_most_one_image()
    {
        $category = factory(Category::class)->create();
        $category->setImage($this->prepareFileUpload('tests/testpic1.png'));
        $category->setImage($this->prepareFileUpload('tests/testpic2.png'));

        $this->assertCount(1, $category->getMedia());
        $category->clearMediaCollection();
    }
}