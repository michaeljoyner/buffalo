<?php


use App\Products\Category;
use App\SiteContent\SiteLinkGenerator;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SiteLinkListGeneratorTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function it_generates_links_for_the_basic_pages()
    {
        $list = SiteLinkGenerator::generate();

        $this->assertArraySubset(['About page' => '/about'], $list);
        $this->assertArraySubset(['Services page' => '/services'], $list);
        $this->assertArraySubset(['Products page' => '/categories'], $list);
        $this->assertArraySubset(['Contact page' => '/contact'], $list);

    }

    /**
     *@test
     */
    public function it_generates_links_for_each_category()
    {
        $categories = factory(Category::class, 5)->create();

        $list = SiteLinkGenerator::generate();

        $categories->each(function($category) use ($list) {
            $this->assertArraySubset([$category->name => '/categories/' . $category->slug], $list);
        });
    }
}