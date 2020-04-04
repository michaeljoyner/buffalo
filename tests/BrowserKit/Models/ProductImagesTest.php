<?php
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/2/16
 * Time: 10:59 AM
 */
class ProductImagesTest extends BrowserKitTestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function an_image_can_be_set_for_a_product()
    {
        $product = factory(Product::class)->create();

        $product->setImage($this->prepareFileUpload('tests/testpic1.png'));
        $this->assertCount(1, $product->getMedia());

        $product->clearMediaCollection();
    }

    /**
     *@test
     */
    public function a_product_with_no_model_image_will_return_its_original_image()
    {
        //create product with existing img
        $category = factory(\App\Products\Category::class)->create(['name' => 'Auto Tools']);
        $product = $category->addProduct(['name' => 'Tool', 'product_code' => '2PIK', 'description' => 'A tool']);
        $product->original_image = '2PIK.jpg';
        $product->save();
        $this->assertCount(0, $product->getMedia());

        $src = $product->imageSrc();
        $this->assertFileExists(public_path($src));
        $this->assertStringContainsString('.jpg', $src);
    }

    /**
     *@test
     */
    public function a_product_knows_if_it_has_a_model_image_set()
    {
        $product = factory(Product::class)->create();
        $this->assertFalse($product->hasModelImageSet(), 'New product has no image');

        $product->setImage($this->prepareFileUpload('tests/testpic1.png'));
        $product = Product::find($product->id);
        $this->assertTrue($product->hasModelImageSet(), 'Product should have image');

        $product->clearMediaCollection();
    }
}