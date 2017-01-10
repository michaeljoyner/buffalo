<?php
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/29/16
 * Time: 9:59 AM
 */
class ProductsAvailabilityControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_products_availability_can_be_set_by_posting_to_endpoint()
    {
        $product = factory(Product::class)->create(['available' => 0]);
        $this->assertFalse($product->available);
        Session::start();
        $this->asLoggedInUser();

        $response = $this->call('POST', '/admin/products/' . $product->id . '/availability', [
            'available' => true
        ]);
        $this->assertOkResponse($response);

        $this->assertTrue(Product::find($product->id)->available);
    }
}