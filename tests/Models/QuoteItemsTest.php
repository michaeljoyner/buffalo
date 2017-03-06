<?php


use App\Products\Product;
use App\Quotes\Quote;
use App\Quotes\QuoteItem;
use App\Sourcing\Supply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuoteItemsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_quote_item_has_necessary_fields()
    {
        $item = factory(QuoteItem::class)->create([
            'package_price' => 2.5,
            'additional_cost_memo' => 'Hanger and logo',
            'profit' => 0.8,
            'moq' => 500,
            'remark' => 'This is an item'
        ]);

        $item->package_price = 3.2;
        $item->additional_cost_memo = 'Just logo';
        $item->profit = 0.9;
        $item->moq = 300;
        $item->remark = 'Not just any item';
        $item->save();

        $item = $item->fresh();

        $this->assertEquals(3.2, $item->package_price);
        $this->assertEquals('Just logo', $item->additional_cost_memo);
        $this->assertEquals(0.9, $item->profit);
        $this->assertEquals(300, $item->moq);
        $this->assertEquals('Not just any item', $item->remark);
    }

    /**
     *@test
     */
    public function a_quote_item_has_all_the_packaging_fields()
    {
        $item = factory(QuoteItem::class)->create([
            'package_type' => 'Hanger',
            'package_unit' => 'Set',
            'package_inner' => 100,
            'package_outer' => 500,
            'package_carton' => '30 inch pallet',
            'net_weight' => 1.6,
            'gross_weight' => 2.2
        ]);

        $item->package_type = 'Card';
        $item->package_unit = 'PC';
        $item->package_inner = 80;
        $item->package_outer = 400;
        $item->package_carton = 'Cardboard box';
        $item->net_weight = 1.4;
        $item->gross_weight = 1.8;
        $item->save();

        $item = $item->fresh();

        $this->assertEquals('Card', $item->package_type);
        $this->assertEquals('PC', $item->package_unit);
        $this->assertEquals(80, $item->package_inner);
        $this->assertEquals(400, $item->package_outer);
        $this->assertEquals('Cardboard box', $item->package_carton);
        $this->assertEquals(1.4, $item->net_weight);
        $this->assertEquals(1.8, $item->gross_weight);
    }

    /**
     *@test
     */
    public function a_quote_item_can_be_updated_to_contain_a_given_products_data()
    {
        $item = factory(QuoteItem::class)->create();
        $product = factory(Product::class)->create([
            'name' => 'Acme product',
            'product_code' => 'TESTCODE123',
            'writeup' => 'Test description',
            'minimum_order_quantity' => 350,
        ]);

        $item->withProductData($product);

        $item = $item->fresh();

        $this->assertEquals('Acme product', $item->name);
        $this->assertEquals('TESTCODE123', $item->buffalo_product_code);
        $this->assertEquals('Test description', $item->description);
        $this->assertEquals(350, $item->moq);
    }

    /**
     *@test
     */
    public function a_quote_item_can_be_updated_to_use_given_packaging_info()
    {
        $item = factory(QuoteItem::class)->create();
        $packaging = factory(\App\Products\Packaging::class)->create([
            'type' => 'Test type',
            'unit' => 'Test unit',
            'inner' => 20,
            'outer' => 100,
            'carton' => '72 inch box',
            'net_weight' => 1.2,
            'gross_weight' => 1.5
        ]);

        $item->withPackagingData($packaging);

        $item = $item->fresh();

        $this->assertEquals('Test type', $item->package_type);
        $this->assertEquals('Test unit', $item->package_unit);
        $this->assertEquals(20, $item->package_inner);
        $this->assertEquals(100, $item->package_outer);
        $this->assertEquals('72 inch box', $item->package_carton);
        $this->assertEquals(1.2, $item->net_weight);
        $this->assertEquals(1.5, $item->gross_weight);
    }

    /**
     *@test
     */
    public function a_quote_item_can_be_updated_with_a_given_supply_data()
    {
        $item = factory(QuoteItem::class)->create();
        $supply = factory(Supply::class)->create([
            'item_number'   => 'TESTCODE123',
            'currency'      => 'NTD',
            'price'         => 200,
            'package_price' => 2.5
        ]);

        $item->withSupplyData($supply);

        $item = $item->fresh();

        $this->assertEquals($supply->supplier->name, $item->supplier_name);
        $this->assertEquals('TESTCODE123', $item->factory_number);
        $this->assertEquals('NTD', $item->currency);
        $this->assertEquals(200, $item->factory_price);
        $this->assertEquals(2.5, $item->package_price);
    }
}