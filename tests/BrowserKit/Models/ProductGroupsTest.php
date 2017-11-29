<?php
use App\Products\ProductGroup;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/25/16
 * Time: 9:45 AM
 */
class ProductGroupsTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_group_can_be_created_and_stored()
    {
        $productGroup = factory(ProductGroup::class)->create();

        $this->assertInstanceOf(ProductGroup::class, $productGroup);
    }



    /**
     *@test
     */
    public function a_product_can_be_added_directly_to_a_product_group()
    {
        $productGroup = factory(ProductGroup::class)->create();
        $productAttributes = [
            'name'         => 'Monkey Wrench',
            'description'  => 'Who wants to be my monkey wrench?',
            'product_code' => 'abcde123'
        ];
        $productGroup->addProduct($productAttributes);

        $this->seeInDatabase('products', array_merge([
            'product_group_id' => $productGroup->id,
            'subcategory_id' => $productGroup->subcategory->id,
            'category_id' => $productGroup->subcategory->category->id
        ], $productAttributes));
    }
}