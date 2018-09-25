<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DeleteProductGalleryImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_image_can_be_deleted_from_a_product_gallery_via_http_request()
    {
        $this->withoutExceptionHandling();
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();
        $image = $product->addGalleryImage(UploadedFile::fake()->image('testpic.png'));
        $this->assertCount(1, $product->galleryImages());

        $response = $this->call('DELETE', '/admin/products/' . $product->id . '/gallery/images/' . $image->id);
        $response->assertStatus(200);

        $this->assertCount(0, $product->galleryImages());

        $product->getGallery()->clearMediaCollection('default');
    }
}