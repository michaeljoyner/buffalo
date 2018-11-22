<?php


namespace Tests\Unit;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductGalleryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_products_images_including_primary_image_can_be_fetched_from_the_product_with_the_primary_image_first()
    {
        Storage::fake('test_media');
        $product = factory(Product::class)->create();
        $product->addGalleryImage(UploadedFile::fake()->image('testpic.jpg'));
        $product->addGalleryImage(UploadedFile::fake()->image('testpic2.jpg'));

        $urls = $product->allImageUrls('web');

        $this->assertCount(3, $urls);
        $this->assertContains(Product::DEFAULT_PRIMARY_IMAGE, $urls[0]);
        $this->assertContains('web.jpg', $urls[1]);
        $this->assertContains('web.jpg', $urls[2]);
    }
}