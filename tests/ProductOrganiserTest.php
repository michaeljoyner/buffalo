<?php


use App\Products\Category;
use App\Products\ProductGroup;
use App\Products\ProductOrganiser;
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductOrganiserTest extends TestCase
{
    use DatabaseMigrations;

    protected $organiser;

    protected function setUp()
    {
        parent::setUp();
        $this->organiser = new ProductOrganiser();
    }

    /**
     * @test
     */
    public function it_can_move_products_from_one_group_to_another()
    {
        $new_group = factory(ProductGroup::class)->create();
        $old_group = factory(ProductGroup::class)->create();
        $products = factory(\App\Products\Product::class, 10)->create([
            'category_id'      => $old_group->subcategory->category->id,
            'subcategory_id'   => $old_group->subcategory->id,
            'product_group_id' => $old_group->id
        ]);

        $this->assertCount(10, $old_group->products);
        $this->assertCount(0, $new_group->products);

        $this->organiser->moveProducts($old_group, $new_group);

        $this->assertCount(10, $old_group->products);
        $this->assertCount(0, $new_group->products);

        $products->each(function ($prod) use ($new_group) {
            $prod = $prod->fresh();
            $this->assertEquals($new_group->id, $prod->product_group_id);
            $this->assertEquals($new_group->subcategory_id, $prod->subcategory_id);
            $this->assertEquals($new_group->subcategory->category->id, $prod->category_id);
        });
    }
    
    /**
     *@test
     */
    public function it_can_move_products_up_a_level()
    {
        $new = factory(Subcategory::class)->create();
        $old_group = factory(ProductGroup::class)->create();
        $products = factory(\App\Products\Product::class, 10)->create([
            'category_id'      => $old_group->subcategory->category->id,
            'subcategory_id'   => $old_group->subcategory->id,
            'product_group_id' => $old_group->id
        ]);

        $this->assertCount(10, $old_group->products);
        $this->assertCount(0, $new->products);

        $this->organiser->moveProducts($old_group, $new);

        $this->assertCount(10, $old_group->products);
        $this->assertCount(0, $new->products);

        $products->each(function ($prod) use ($new) {
            $prod = $prod->fresh();
            $this->assertEquals(null, $prod->product_group_id);
            $this->assertEquals($new->id, $prod->subcategory_id);
            $this->assertEquals($new->category->id, $prod->category_id);
        });
    }
    
    /**
     *@test
     */
    public function it_can_move_products_down_a_level()
    {
        $new = factory(Subcategory::class)->create();
        $old = factory(Category::class)->create();
        $products = factory(\App\Products\Product::class, 10)->create([
            'category_id'      => $old->id,
            'subcategory_id'   => null,
            'product_group_id' => null
        ]);

        $this->assertCount(10, $old->products);
        $this->assertCount(0, $new->products);

        $this->organiser->moveProducts($old, $new);

        $this->assertCount(10, $old->products);
        $this->assertCount(0, $new->products);

        $products->each(function ($prod) use ($new) {
            $prod = $prod->fresh();
            $this->assertEquals(null, $prod->product_group_id);
            $this->assertEquals($new->id, $prod->subcategory_id);
            $this->assertEquals($new->category->id, $prod->category_id);
        });
    }

    /**
     *@test
     */
    public function it_deletes_an_empty_group()
    {
        $productGroup = factory(ProductGroup::class)->create();

        $this->organiser->pruneEmpty($productGroup);

        $this->assertSoftDeleted($productGroup);
    }

    /**
     *@test
     */
    public function it_wont_delete_a_non_empty_group()
    {
        $productGroup = factory(ProductGroup::class)->create();
        $productGroup->addProduct(['name' => 'acme product', 'product_code' => '12345', 'description' => 'a product']);

        $this->organiser->pruneEmpty($productGroup);

        $productGroup = $productGroup->fresh();

        $this->assertNull($productGroup->deleted_at);
    }

    /**
     *@test
     */
    public function get_new_group_creates_a_subcategory_of_a_category()
    {
        $category = factory(Category::class)->create();

        $subcategory = $this->organiser->getNewGroup($category, 'Sexy Subcategory', 'A description');

        $this->assertInstanceOf(Subcategory::class, $subcategory);
        $this->assertEquals($category->id, $subcategory->category_id);
        $this->seeInDatabase('subcategories', ['id' => $subcategory->id]);
    }

    /**
     *@test
     */
    public function get_new_group_will_return_an_existing_subcategory_of_same_name()
    {
        $category = factory(Category::class)->create();
        $old_sub = $category->addSubcategory(['name' => 'Sexy Subcategory', 'description' => 'The first of its kind']);

        $subcategory = $this->organiser->getNewGroup($category, 'Sexy Subcategory', 'A description');

        $this->assertInstanceOf(Subcategory::class, $subcategory);
        $this->assertEquals($old_sub->id, $subcategory->id);
    }

    /**
     *@test
     */
    public function get_new_group_creates_a_product_group_for_a_subcategory()
    {
        $subcategory = factory(Subcategory::class)->create();

        $productGroup = $this->organiser->getNewGroup($subcategory, 'Good Group', 'A description');

        $this->assertInstanceOf(ProductGroup::class, $productGroup);
        $this->assertEquals($subcategory->id, $productGroup->subcategory_id);
        $this->seeInDatabase('product_groups', ['id' => $productGroup->id]);
    }

    /**
     *@test
     */
    public function get_new_group_will_return_an_existing_product_group_of_same_name()
    {
        $subcategory = factory(Subcategory::class)->create();
        $old_pg = $subcategory->addProductGroup(['name' => 'Good Group', 'description' => 'The first of its kind']);

        $productGroup = $this->organiser->getNewGroup($subcategory, 'Good Group', 'A description');

        $this->assertInstanceOf(ProductGroup::class, $productGroup);
        $this->assertEquals($old_pg->id, $productGroup->id);
    }
}