<?php


use App\Products\Packaging;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductPackagingControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function packaging_data_is_stored_on_the_product()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();

        $this->makePostRequest($product)
             ->assertResponseStatus(302)
             ->seeInDatabase('packaging', array_merge(['product_id' => $product->id], $this->getBasePackageData()));
    }

    /**
     * @test
     */
    public function packaging_type_is_required()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();

        $this->makePostRequest($product, ['type' => null])
             ->assertResponseStatus(302)
             ->assertSessionHasErrors('type');
        $this->notSeeInDatabase('packaging', ['product_id' => $product->id]);
    }

    /**
     * @test
     */
    public function packaging_unit_is_required()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();

        $this->makePostRequest($product, ['unit' => null])
             ->assertResponseStatus(302)
             ->assertSessionHasErrors('unit');
        $this->notSeeInDatabase('packaging', ['product_id' => $product->id]);
    }

    /**
     * @test
     */
    public function packaging_inner_must_be_numeric()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();

        $this->makePostRequest($product, ['inner' => 'not a number'])
             ->assertResponseStatus(302)
             ->assertSessionHasErrors('inner');
        $this->notSeeInDatabase('packaging', ['product_id' => $product->id]);
    }

    /**
     * @test
     */
    public function packaging_outer_must_be_numeric()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();

        $this->makePostRequest($product, ['outer' => 'not a number'])
             ->assertResponseStatus(302)
             ->assertSessionHasErrors('outer');
        $this->notSeeInDatabase('packaging', ['product_id' => $product->id]);
    }

    /**
     * @test
     */
    public function packaging_net_weight_must_be_numeric()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();

        $this->makePostRequest($product, ['net_weight' => 'not a number'])
             ->assertResponseStatus(302)
             ->assertSessionHasErrors('net_weight');
        $this->notSeeInDatabase('packaging', ['product_id' => $product->id]);
    }

    /**
     * @test
     */
    public function packaging_gross_weight_must_be_numeric()
    {
        $product = factory(Product::class)->create();
        $this->asLoggedInUser();

        $this->makePostRequest($product, ['gross_weight' => 'not a number'])
             ->assertResponseStatus(302)
             ->assertSessionHasErrors('gross_weight');
        $this->notSeeInDatabase('packaging', ['product_id' => $product->id]);
    }

    /**
     * @test
     */
    public function a_product_packaging_is_correctly_updated()
    {
        $packaging = factory(Packaging::class)->create();
        $newData = [
            'type'         => 'Slide Card',
            'unit'         => 'Set',
            'inner'        => 24,
            'outer'        => 96,
            'carton'       => 'big box',
            'net_weight'   => 1.22,
            'gross_weight' => 2
        ];

        $this->asLoggedInUser();
        $this->post('/admin/packaging/' . $packaging->id, $newData)
             ->assertResponseStatus(302)
             ->seeInDatabase('packaging', array_merge(['id' => $packaging->id], $newData));
    }

    /**
     * @test
     */
    public function packaging_can_be_deleted()
    {
        $packaging = factory(Packaging::class)->create();

        $this->asLoggedInUser();
        $this->delete('/admin/packaging/' . $packaging->id)
             ->assertResponseStatus(302)
             ->notSeeInDatabase('packaging', ['id' => $packaging->id]);
    }

    protected function makePostRequest($product, $data = [])
    {
        $packageData = [
            'type'         => 'Hanger',
            'unit'         => 'PC',
            'inner'        => 32,
            'outer'        => 96,
            'carton'       => '72 inch',
            'net_weight'   => 1.55,
            'gross_weight' => 2.6
        ];
        $postData = array_merge($packageData, $data);
        $this->post('/admin/products/' . $product->id . '/packaging', $postData);

        return $this;
    }

    protected function getBasePackageData()
    {
        return [
            'type'         => 'Hanger',
            'unit'         => 'PC',
            'inner'        => 32,
            'outer'        => 96,
            'carton'       => '72 inch',
            'net_weight'   => 1.55,
            'gross_weight' => 2.6
        ];
    }
}