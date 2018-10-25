<?php


namespace Tests\Feature;


use App\Products\Product;
use App\Sourcing\Supplier;
use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CreateProductSupplyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_new_supply_is_correctly_stored_on_the_product()
    {
        $product = factory(Product::class)->create();
        $supplier = factory(Supplier::class)->create();
        $this->asLoggedInUser();

        $today = Carbon::now()->format('Y-m-d');
        $thirtyDaysLater = Carbon::parse('+30 days')->format('Y-m-d');

        $response = $this->post('/admin/products/' . $product->id . '/supplies', [
            'quoted_date'   => $today,
            'valid_until'   => $thirtyDaysLater,
            'supplier_id'   => $supplier->id,
            'item_number'   => '12345',
            'currency'      => 'twd',
            'price'         => 1000,
            'package_price' => 20,
            'remarks'       => ''
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('supplies', [
            'product_id'    => $product->id,
            'quoted_date'   => $today . ' 00:00:00',
            'valid_until'   => $thirtyDaysLater . ' 00:00:00',
            'supplier_id'   => $supplier->id,
            'item_number'   => '12345',
            'currency'      => 'twd',
            'price'         => 1000,
            'package_price' => 20,
            'remarks'       => null
        ]);
    }

    /**
     * @test
     */
    public function a_new_supply_is_can_be_stored_without_item_number_or_remarks()
    {
        $product = factory(Product::class)->create();
        $supplier = factory(Supplier::class)->create();
        $this->asLoggedInUser();

        $today = Carbon::now()->format('Y-m-d');
        $thirtyDaysLater = Carbon::parse('+30 days')->format('Y-m-d');

        $response = $this->post('/admin/products/' . $product->id . '/supplies', [
            'quoted_date'   => $today,
            'valid_until'   => $thirtyDaysLater,
            'supplier_id'   => $supplier->id,
            'currency'      => 'twd',
            'price'         => 1000,
            'package_price' => 20,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('supplies', [
            'product_id'    => $product->id,
            'quoted_date'   => $today . ' 00:00:00',
            'valid_until'   => $thirtyDaysLater . ' 00:00:00',
            'supplier_id'   => $supplier->id,
            'item_number'   => null,
            'currency'      => 'twd',
            'price'         => 1000,
            'package_price' => 20,
            'remarks'       => null
        ]);
    }

    /**
     * @test
     */
    public function a_supply_is_correctly_deleted()
    {
        $supply = factory(Supply::class)->create();
        $this->asLoggedInUser();

        $response = $this->delete('/admin/supplies/' . $supply->id);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('supplies', ['id' => $supply->id]);
    }
}