<?php


use App\Products\Category;
use App\Products\Product;
use App\Products\ProductGroup;
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductCategoryControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_gets_moved_to_the_correct_category()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();
        $newCategory = factory(Category::class)->create();

        $this->post('/admin/products/' . $product->id . '/category/' . $newCategory->id);

        $this->seeInDatabase('products', [
            'id' => $product->id,
            'category_id' => $newCategory->id
        ]);
    }
    
    /**
     *@test
     */
    public function a_product_gets_moved_to_the_correct_subcategory()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();
        $newSubcategory = factory(Subcategory::class)->create();

        $this->post('/admin/products/' . $product->id . '/subcategory/' . $newSubcategory->id);

        $this->seeInDatabase('products', [
            'id' => $product->id,
            'category_id' => $newSubcategory->category->id,
            'subcategory_id' => $newSubcategory->id
        ]);
    }

    /**
     *@test
     */
    public function a_product_gets_moved_to_the_correct_product_group()
    {
        $this->asLoggedInUser();
        $product = factory(Product::class)->create();
        $newProductGroup = factory(ProductGroup::class)->create();

        $this->post('/admin/products/' . $product->id . '/productgroup/' . $newProductGroup->id);

        $this->seeInDatabase('products', [
            'id' => $product->id,
            'category_id' => $newProductGroup->subcategory->category->id,
            'subcategory_id' => $newProductGroup->subcategory->id,
            'product_group_id' => $newProductGroup->id,
        ]);
    }
}