<?php


use App\Products\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryOrderControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function it_correctly_updates_the_categories_order()
    {
        $this->asLoggedInUser();
        $categories = factory(Category::class, 5)->create();

        $this->post('/admin/categories/order', ['order' => [4,1,5,3,2]])
            ->assertResponseOk();

        $this->assertCategoryOrder([4,1,5,3,2]);
    }

    protected function assertCategoryOrder($positions)
    {
        collect($positions)->each(function($id, $zeroed_position) {
            $this->assertEquals($zeroed_position + 1, Category::find($id)->position);
        });
    }
}