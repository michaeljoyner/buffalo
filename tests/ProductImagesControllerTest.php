<?php
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/3/16
 * Time: 9:26 AM
 */
class ProductImagesControllerTest extends TestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function an_image_can_be_uploaded_an_set_on_a_given_product()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();

        $response = $this->call('POST', '/admin/products/' . $product->id . '/image', [], [], [
            'file' => $this->prepareFileUpload('tests/testpic1.png')
        ]);
        $this->assertOkResponse($response);

        $this->assertCount(1, $product->getMedia());
        $product->clearMediaCollection();
    }
}