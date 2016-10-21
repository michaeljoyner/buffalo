<?php


use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductGalleriesControllerTest extends TestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function an_image_can_be_added_to_a_product_gallery_by_posting_to_correct_endpoint()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();

        $response = $this->call('POST', '/admin/products/' . $product->id . '/gallery/images', [], [], [
            'file' => $this->prepareFileUpload('tests/testpic1.png')
        ]);
        $this->assertOkResponse($response);

        $this->assertCount(1, $product->galleryImages());
    }

    /**
     *@test
     */
    public function an_image_can_be_deleted_from_a_product_gallery_via_http_request()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();
        $image = $product->addGalleryImage($this->prepareFileUpload('tests/testpic1.png'));
        $this->assertCount(1, $product->galleryImages());

        $response = $this->call('DELETE', '/admin/products/' . $product->id . '/gallery/images/' . $image->id);
        $this->assertOkResponse($response);

        $this->assertCount(0, $product->galleryImages());
    }
}