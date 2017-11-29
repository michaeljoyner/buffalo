<?php


use App\Products\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryOrderTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_category_has_a_persisted_position_attribute()
    {
        $category = factory(Category::class)->create(['position' => 3]);

        $this->seeInDatabase('categories', ['id' => $category->id, 'position' => 3]);
    }

    /**
     *@test
     */
    public function the_order_of_categories_can_be_set_by_passing_array_of_ids_in_desired_order()
    {
        $categories = factory(Category::class, 10)->create();


        Category::setOrder([10,1,9,2,8,5,4,7,3,6]);

        $this->assertCategoryOrder([10,1,9,2,8,5,4,7,3,6]);
    }

    /**
     *@test
     */
    public function categories_not_included_in_the_order_set_have_position_reset_to_null()
    {
        foreach(range(1,10) as $position) {
            factory(Category::class)->create(['position' => $position]);
        }

        Category::setOrder([7,2,9]);

        $this->assertCategoryOrder([7,2,9]);

        collect([1,3,4,5,6,8,10])->each(function($id) {
            $this->assertNull(Category::find($id)->position);
        });
    }

    /**
     *@test
     */
    public function the_categories_can_be_returned_in_order()
    {
        $order_array = [10,1,9,2,8,5,4,7,3,6];
        factory(Category::class, 10)->create();
        Category::setOrder($order_array);

        $ordered = Category::getOrdered();

        $ordered->each(function($category, $index) use ($order_array) {
           $this->assertEquals($category->id, $order_array[$index]);
        });
    }

    protected function assertCategoryOrder($positions)
    {
        collect($positions)->each(function($id, $zeroed_position) {
           $this->assertEquals($zeroed_position + 1, Category::find($id)->position);
        });
    }


}