<?php
use App\Products\Category;
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/25/16
 * Time: 9:39 AM
 */
class SubcategoriesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_subcategory_can_be_created_and_stored()
    {
        $subcategory = factory(Subcategory::class)->create();

        $this->assertInstanceOf(Subcategory::class, $subcategory);
    }

    /**
     * @test
     */
    public function a_product_group_can_be_added_to_a_subcategory()
    {
        $subcategory = factory(Subcategory::class)->create();
        $subcategory->addProductGroup([
            'name'        => 'Acme Product Group',
            'description' => 'It is the little things'
        ]);

        $this->seeInDatabase('product_groups', [
            'subcategory_id' => $subcategory->id,
            'name'           => 'Acme Product Group',
            'description'    => 'It is the little things'
        ]);
    }


    /**
     * @test
     */
    public function a_product_can_be_added_directly_to_a_subcategory()
    {
        $subcategory = factory(Subcategory::class)->create();
        $productAttributes = [
            'name'         => 'Monkey Wrench',
            'description'  => 'Who wants to be my monkey wrench?',
            'product_code' => 'abcde123'
        ];

        $subcategory->addProduct($productAttributes);

        $this->seeInDatabase('products',
            array_merge(['subcategory_id' => $subcategory->id, 'category_id' => $subcategory->category->id],
                $productAttributes));
    }
}