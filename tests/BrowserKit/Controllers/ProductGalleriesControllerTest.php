<?php


use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductGalleriesControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function an_image_can_be_added_to_a_product_gallery_by_posting_to_correct_endpoint()
    {
        $this->disableExceptionHandling();
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();

        $response = $this->call('POST', '/admin/products/' . $product->id . '/gallery/images', [], [], [
            'file' => $this->prepareFileUpload('tests/testpic1.png')
        ]);
        $this->assertOkResponse($response);

        $this->assertCount(1, $product->galleryImages());
    }


}