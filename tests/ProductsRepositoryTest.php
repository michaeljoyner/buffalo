<?php


use App\Products\Product;
use App\Products\ProductsRepository;
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
     *@test
     */
    public function the_repository_can_be_searched()
    {
        $product = factory(Product::class)->create(['product_code' => 'PC123']);

        $results = $this->repo->search('PC123');

        $this->assertCount(1, $results);
        $this->assertResultsContainsProduct($results, $product);
    }

    /**
     *@test
     */
    public function search_matches_on_product_name()
    {
        $product = factory(Product::class)->create(['name' => 'a wonderful acme product']);

        $results = $this->repo->search('wonder');

        $this->assertResultsContainsProduct($results, $product);
        $this->assertCount(1, $results);
    }

    /**
     *@test
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
        if(! is_array($product)) {
            $product = [$product];
        }
        foreach($product as $item) {
            $this->assertTrue($results->contains($item), 'expected product [' . $item->name . '] does not exist in results');
        }
    }
}