<?php


use App\Products\Category;
use App\Products\Product;
use App\Products\ProductGroup;
use App\Products\ProductsRepository;
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductsRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    protected $repo;

    protected function setUp()
    {
        parent::setUp();
        $this->repo = new ProductsRepository;
    }

    /**
     * @test
     */
    public function the_repository_can_be_searched()
    {
        $product = factory(Product::class)->create(['product_code' => 'PC123']);

        $results = $this->repo->search('PC123');

        $this->assertCount(1, $results);
        $this->assertResultsContainsProduct($results, $product);
    }

    /**
     * @test
     */
    public function search_matches_on_product_name()
    {
        $product = factory(Product::class)->create(['name' => 'a wonderful acme product']);

        $results = $this->repo->search('wonder');

        $this->assertResultsContainsProduct($results, $product);
        $this->assertCount(1, $results);
    }

    /**
     * @test
     */
    public function a_matching_product_code_takes_preference()
    {
        $product1 = factory(Product::class)->create(['product_code' => 'COOL']);
        $product2 = factory(Product::class)->create(['name' => 'Totally uncool thing']);

        $results = $this->repo->search('cool');

        $this->assertResultsContainsProduct($results, [$product1, $product2]);
        $this->assertCount(2, $results);
        $this->assertEquals($product1->id, $results->first()->id);
    }

    protected function assertResultsContainsProduct($results, $product)
    {
        if (!is_array($product)) {
            $product = [$product];
        }
        foreach ($product as $item) {
            $this->assertTrue($results->contains($item),
                'expected product [' . $item->name . '] does not exist in results');
        }
    }

    /**
     * @test
     */
    public function a_random_number_of_products_can_be_fetched_from_the_repo()
    {
        factory(Product::class, 20)->create();
        $products = $this->repo->getRandom(8, false);

        $this->assertCount(8, $products);
    }

    /**
     * @test
     */
    public function related_products_can_be_fetched_from_a_product_and_are_from_same_product_group_if_possible()
    {
        $productGroup = factory(ProductGroup::class)->create();

        factory(Product::class, 7)->create(['product_group_id' => $productGroup->id]);

        $product = Product::first();
        $related = $this->repo->relatedProducts($product);

        $this->assertCount(4, $related);

        $related->each(function ($relatedProduct) use ($product, $productGroup) {
            $this->assertEquals($productGroup->id, $relatedProduct->product_group_id);
            $this->assertNotEquals($product->id, $relatedProduct->id);
        });
    }

    /**
     * @test
     */
    public function related_products_will_be_from_the_same_subcategory_if_the_can()
    {
        $subcategory = factory(Subcategory::class)->create();
        $productGroup = factory(ProductGroup::class)->create();
        $productGroup2 = factory(ProductGroup::class)->create();

        $sameGroup = factory(Product::class, 3)->create([
            'product_group_id' => $productGroup->id,
            'subcategory_id'   => $subcategory->id
        ]);
        $sameCatDiffGroup = factory(Product::class, 3)->create([
            'product_group_id' => $productGroup2->id,
            'subcategory_id'   => $subcategory->id
        ]);

        $product = $sameGroup->first();

        $related = $this->repo->relatedProducts($product);

        $this->assertCount(4, $related);
        $this->assertCount(2, $related->filter(function ($p) use ($productGroup) {
            return $p->product_group_id == $productGroup->id;
        }));

        $related->each(function ($relatedProduct) use ($product, $subcategory) {
            $this->assertEquals($subcategory->id, $relatedProduct->subcategory_id);
            $this->assertNotEquals($product->id, $relatedProduct->id);
        });
    }

    /**
     *@test
     */
    public function related_products_will_be_filled_with_products_from_same_category_if_neccessary()
    {
        $category = factory(Category::class)->create();

        factory(Product::class)->create(['subcategory_id' => 1, 'product_group_id' => 7, 'category_id' => $category->id]);
        factory(Product::class)->create(['subcategory_id' => 2, 'product_group_id' => 8, 'category_id' => $category->id]);
        factory(Product::class)->create(['subcategory_id' => 3, 'product_group_id' => 9, 'category_id' => $category->id]);
        factory(Product::class)->create(['subcategory_id' => 4, 'product_group_id' => 10, 'category_id' => $category->id]);
        factory(Product::class)->create(['subcategory_id' => 5, 'product_group_id' => 11, 'category_id' => $category->id]);
        factory(Product::class)->create(['subcategory_id' => 6, 'product_group_id' => 12, 'category_id' => $category->id]);

        $product = Product::first();
        $related = $this->repo->relatedProducts($product);

        $this->assertCount(4, $related);
        $related->each(function ($relatedProduct) use ($product, $category) {
            $this->assertEquals($category->id, $relatedProduct->category_id);
            $this->assertNotEquals($product->id, $relatedProduct->id);
        });
    }

    /**
     *@test
     */
    public function a_collection_of_eight_products_will_be_returned_for_featured_products_with_as_many_as_possible_being_promoted()
    {
        factory(Product::class, 3)->create(['is_promoted' => true, 'promoted_until' => \Carbon\Carbon::now()->addDays(30)]);
        factory(Product::class, 10)->create();

        $promoted = $this->repo->featuredProducts();

        $this->assertCount(8, $promoted);
        $this->assertCount(3, $promoted->filter(function($product) { return $product->is_promoted; }));
    }
}