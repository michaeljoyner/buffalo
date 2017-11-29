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

    /**
     *@test
     */
    public function a_products_images_including_primary_image_can_be_fetched_from_the_product_with_the_primary_image_first()
    {
        $product = factory(Product::class)->create();
        $product->addGalleryImage($this->prepareFileUpload('tests/testpic1.png'));
        $product->addGalleryImage($this->prepareFileUpload('tests/testpic2.png'));

        $urls = $product->allImageUrls('web');

        $this->assertCount(3, $urls);
        $this->assertContains(Product::DEFAULT_PRIMARY_IMAGE, $urls[0]);
        $this->assertContains('web.png', $urls[1]);
        $this->assertContains('web.png', $urls[2]);
    }
}