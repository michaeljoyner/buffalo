<?php


use App\Products\Product;
use App\Sourcing\Supplier;
use App\Sourcing\Supply;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuppliesControllerTest extends TestCase
{
    use DatabaseMigrations;

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

        $this->post('/admin/products/' . $product->id . '/supplies', [
            'quoted_date'   => $today,
            'valid_until'   => $thirtyDaysLater,
            'supplier_id'   => $supplier->id,
            'item_number'   => '12345',
            'currency'      => 'twd',
            'price'         => 1000,
            'package_price' => 20,
            'remarks'       => ''
        ])->assertResponseStatus(302)
            ->seeInDatabase('supplies', [
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
    public function a_supply_is_correctly_deleted()
    {
        $supply = factory(Supply::class)->create();
        $this->asLoggedInUser();

        $this->delete('/admin/supplies/' . $supply->id)
            ->assertResponseStatus(302)
            ->notSeeInDatabase('supplies', ['id' => $supply->id]);
    }
}