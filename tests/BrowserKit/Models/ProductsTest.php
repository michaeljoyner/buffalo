<?php
use App\Products\Category;
use App\Products\Product;
use App\Products\ProductGroup;
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/25/16
 * Time: 9:08 AM
 */
class ProductsTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_can_be_created_and_stored_in_db()
    {
        $product = factory(Product::class)->create();

        $this->assertInstanceOf(Product::class, $product);
    }

    /**
     *@test
     */
    public function a_products_availability_can_be_set()
    {
        $product = factory(Product::class)->create(['available' => 1]);
        $this->assertTrue($product->available);

        $product->makeAvailable(false);
        $this->assertFalse($product->available);

        $product->makeAvailable(true);
        $this->assertTrue($product->available);
    }

    /**
     *@test
     */
    public function a_product_is_not_promoted_by_default()
    {
        $product = factory(Product::class)->create();

        $this->assertFalse($product->is_promoted);
    }

    /**
     *@test
     */
    public function a_product_can_be_promoted_by_giving_a_date_to_promote_until()
    {
        $product = factory(Product::class)->create();
        $product->promote(\Carbon\Carbon::now()->addDays(30));

        $this->assertTrue($product->isPromoted());
        $this->assertEquals(30, \Carbon\Carbon::now()->diffInDays($product->promoted_until));
    }

    /**
     *@test
     */
    public function a_product_can_be_demoted()
    {
        $product = factory(Product::class)->create();
        $product->promote(\Carbon\Carbon::now()->addDays(30));

        $product->demote();
        $this->assertFalse($product->isPromoted());
    }

    /**
     *@test
     */
    public function a_product_can_be_moved_to_an_unrelated_category()
    {
        $product = factory(Product::class)->create();
        $newCategory = factory(Category::class)->create();

        $product->moveToCategory($newCategory->id);
        $product = Product::find($product->id);

        $this->assertEquals($newCategory->id, $product->category->id);
        $this->assertNull($product->subcategory_id);
        $this->assertNull($product->product_group_id);
    }

    /**
     *@test
     */
    public function a_product_can_be_moved_to_an_unrelated_subcategory()
    {
        $product = factory(Product::class)->create();
        $newSubcategory = factory(Subcategory::class)->create();

        $product->moveToSubcategory($newSubcategory->id);
        $product = Product::find($product->id);

        $this->assertEquals($newSubcategory->id, $product->subcategory->id);
        $this->assertEquals($newSubcategory->category->id, $product->category->id);
        $this->assertNull($product->product_group_id);
    }

    /**
     *@test
     */
    public function a_product_can_be_moved_to_an_unrelated_product_group()
    {
        $product = factory(Product::class)->create();
        $newProductGroup = factory(ProductGroup::class)->create();

        $product->moveToProductGroup($newProductGroup->id);
        $product = Product::find($product->id);

        $this->assertEquals($newProductGroup->subcategory->category->id, $product->category->id);
        $this->assertEquals($newProductGroup->subcategory->id, $product->subcategory->id);
        $this->assertEquals($newProductGroup->id, $product->productGroup->id);
    }
    
    /**
     *@test
     */
    public function a_product_that_is_newly_created_is_not_automatically_new()
    {
        $newProduct = factory(Product::class)->create();
        $oldProduct = factory(Product::class)->create(['created_at' => \Carbon\Carbon::create(2010,2,2)]);

        $this->assertFalse($newProduct->isNew());
        $this->assertFalse($oldProduct->isNew());
    }

    /**
     *@test
     */
    public function a_product_with_a_true_value_for_marked_new_is_new()
    {
        $oldProduct = factory(Product::class)->create(['created_at' => \Carbon\Carbon::create(2010,2,2)]);
        $oldProduct->marked_new = true;

        $this->assertTrue($oldProduct->isNew());
    }

    /**
     *@test
     */
    public function a_product_that_is_marked_new_has_a_new_until_date_set()
    {
        $product = factory(Product::class)->create(['marked_new' => false]);

        $product->markAsNew(true);

        $this->assertNotNull($product->new_until);
        $this->assertEquals(Product::DAYS_TO_BE_NEW, \Carbon\Carbon::now()->diffInDays($product->new_until));
    }

    /**
     *@test
     */
    public function a_product_has_marked_new_set_to_false_as_default()
    {
        $product = factory(Product::class)->create();
        $this->assertFalse($product->marked_new);
    }

    /**
     *@test
     */
    public function a_products_marked_new_value_can_be_toggled()
    {
        $product = factory(Product::class)->create();

        $product->markAsNew(true);
        $this->assertTrue($product->marked_new);

        $product->markAsNew(false);
        $this->assertFalse($product->marked_new);
    }

    /**
     *@test
     */
    public function a_product_that_has_its_new_status_manually_removed_is_has_its_new_until_date_set_back_to_null()
    {
        $product = factory(Product::class)->create();
        $product->markAsNew(true);
        $this->assertNotNull($product->new_until);

        $product->markAsNew(false);
        $this->assertNull($product->new_until);
    }

    /**
     *@test
     */
    public function a_product_can_be_marked_as_new_for_a_given_number_of_days_from_now()
    {
        $product = factory(Product::class)->create();
        $product->markAsNew(true, $days = 33);

        $this->assertTrue($product->isNew());
        $this->assertEquals(33, $product->new_until->diffInDays(\Carbon\Carbon::now()));
    }

    /**
     *@test
     */
    public function a_new_product_with_a_new_until_date_set_can_also_have_its_new_until_date_reset_to_a_new_value()
    {
        $product = factory(Product::class)->create();
        $product->markAsNew(true, $days = 33);
        $product = $product->fresh();

        $product->markAsNew(true, $days = 11);

        $this->assertTrue($product->isNew());
        $this->assertEquals(11, $product->new_until->diffInDays(\Carbon\Carbon::now()));
    }

    /**
     *@test
     */
    public function a_product_can_tell_how_many_days_it_is_new_for()
    {
        $product = factory(Product::class)->create();
        $product->markAsNew(true, $days = 33);

        $this->assertEquals(33, $product->daysStillNew());
    }

    /**
     *@test
     */
    public function a_product_can_have_a_minimum_order_quantity()
    {
        $product = factory(Product::class)->create();

        $product->minimum_order_quantity = 500;
        $product->save();

        $this->assertEquals(500, $product->fresh()->minimum_order_quantity);
    }
}