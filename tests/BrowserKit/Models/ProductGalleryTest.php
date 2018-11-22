<?php


use App\Products\Product;
use App\Products\ProductGallery;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductGalleryTest extends BrowserKitTestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function a_product_has_an_empty_gallery_by_default()
    {
        $product = factory(Product::class)->create();
        $this->assertInstanceOf(ProductGallery::class, $product->getGallery());

        $galleryImages = $product->galleryImages();
        $this->assertCount(0, $galleryImages);
    }

    /**
     *@test
     */
    public function an_image_can_be_added_to_the_products_gallery()
    {
        $product = factory(Product::class)->create();
        $product->addGalleryImage($this->prepareFileUpload('tests/testpic1.png'));

        $this->assertCount(1, $product->galleryImages());
    }


}