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
class ProductsTest extends TestCase
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
    public function a_product_can_be_promoted()
    {
        $product = factory(Product::class)->create();
        $product->promote();

        $this->assertTrue($product->is_promoted);
    }

    /**
     *@test
     */
    public function a_product_can_be_demoted()
    {
        $product = factory(Product::class)->create(['is_promoted' => true]);
        $product->demote();

        $this->assertFalse($product->is_promoted);
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
    public function a_product_created_in_the_last_month_is_considered_new()
    {
        $newProduct = factory(Product::class)->create();
        $oldProduct = factory(Product::class)->create(['created_at' => \Carbon\Carbon::create(2010,2,2)]);

        $this->assertTrue($newProduct->isNew());
        $this->assertFalse($oldProduct->isNew());
    }

    /**
     *@test
     */
    public function a_product_with_a_true_value_for_mark_new_is_new()
    {
        $oldProduct = factory(Product::class)->create(['created_at' => \Carbon\Carbon::create(2010,2,2)]);
        $oldProduct->marked_new = true;

        $this->assertTrue($oldProduct->isNew());
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
}