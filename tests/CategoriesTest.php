<?php
use App\Products\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\MediaLibrary\Media;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/25/16
 * Time: 9:28 AM
 */
class CategoriesTest extends TestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     * @test
     */
    public function a_category_can_be_created_and_stored()
    {
        $category = factory(Category::class)->create();

        $this->assertInstanceOf(Category::class, $category);
    }

    /**
     * @test
     */
    public function a_subcategory_can_be_added_to_a_category()
    {
        $category = factory(Category::class)->create();

        $category->addSubcategory([
            'name'        => 'Subway',
            'description' => 'Its a sub'
        ]);

        $this->seeInDatabase('subcategories', [
            'category_id' => $category->id,
            'name'        => 'Subway',
            'description' => 'Its a sub'
        ]);
    }

    /**
     * @test
     */
    public function a_product_may_be_added_to_a_category()
    {
        $category = factory(Category::class)->create();
        $productAttributes = [
            'name'         => 'Monkey Wrench',
            'description'  => 'Who wants to be my monky wrench?',
            'product_code' => 'abcde123'
        ];

        $category->addProduct($productAttributes);

        $this->seeInDatabase('products', array_merge(['category_id' => $category->id], $productAttributes));
    }

    /**
     * @test
     */
    public function deleting_a_category_will_soft_delete_its_subcategories_product_groups_and_products()
    {
        $category = factory(Category::class)->create();
        $subcategory = $category->addSubcategory(['name' => 'Subway', 'description' => 'Its a sub']);
        $product_group = $subcategory->addProductGroup(['name' => 'Groopy', 'description' => 'Acme group']);
        $product = $product_group->addProduct([
            'name'         => 'Monkey Wrench',
            'product_code' => '12345',
            'description'  => 'A tool'
        ]);

        $this->assertNull($category->deleted_at);
        $this->assertNull($subcategory->deleted_at);
        $this->assertNull($product_group->deleted_at);
        $this->assertNull($product->deleted_at);

        $category->delete();

        $this->assertSoftDeleted($category);
        $this->assertSoftDeleted($subcategory);
        $this->assertSoftDeleted($product_group);
        $this->assertSoftDeleted($product);
    }

    /**
     *@test
     */
    public function deleting_a_category_also_soft_deletes_its_products_not_in_any_subcategory_or_product_group()
    {
        $category = factory(Category::class)->create();
        $subcategory = $category->addSubcategory(['name' => 'Subway', 'description' => 'Its a sub']);
        $product_group = $subcategory->addProductGroup(['name' => 'Groopy', 'description' => 'Acme group']);

        $prod1 = $category->addProduct(['name' => 'name1', 'product_code' => '123', 'description' => 'brief']);
        $prod2 = $subcategory->addProduct(['name' => 'name2', 'product_code' => '223', 'description' => 'brief']);
        $prod3 = $product_group->addProduct(['name' => 'name3', 'product_code' => '323', 'description' => 'brief']);

        $category->delete();

        $this->assertSoftDeleted($prod1);
        $this->assertSoftDeleted($prod2);
        $this->assertSoftDeleted($prod3);
    }

    /**
     *@test
     */
    public function a_banner_image_can_be_set_for_a_category_image()
    {
        $category = factory(Category::class)->create();

        $category->setBannerImage($this->prepareFileUpload('tests/testpic1.png'));

        $category = $category->fresh();

        $this->assertCount(1, $category->bannerImage->getMedia());

        $category->bannerImage->clearMediaCollection();
    }

    /**
     *@test
     */
    public function a_banner_image_can_be_reset()
    {
        $category = factory(Category::class)->create();
        $category->setBannerImage($this->prepareFileUpload('tests/testpic1.png'));
        $category = $category->fresh();
        $orinigalBannerId = $category->bannerImage->getMedia()->first()->id;

        $category->setBannerImage($this->prepareFileUpload('tests/testpic2.png'));
        $category = $category->fresh();
        $this->assertCount(1, $category->bannerImage->getMedia());
        $this->assertNotEquals($orinigalBannerId, $category->bannerImage->getMedia()->first()->id);

        $category->bannerImage->clearMediaCollection();
    }

    /**
     *@test
     */
    public function a_category_has_a_default_banner_src()
    {
        $category = factory(Category::class)->create();

        $this->assertEquals(Category::DEFAULT_BANNER_SRC, $category->bannerSrc());
    }
}