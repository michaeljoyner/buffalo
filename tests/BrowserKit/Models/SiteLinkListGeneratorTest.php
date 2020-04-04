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

        $this->assertEquals('/about', $list['About page']);
        $this->assertEquals('/services', $list['Services page']);
        $this->assertEquals('/categories', $list['Products page']);
        $this->assertEquals('/contact', $list['Contact page']);

    }

    /**
     *@test
     */
    public function it_generates_links_for_each_category()
    {
        $categories = factory(Category::class, 5)->create();

        $list = SiteLinkGenerator::generate();

        $categories->each(function($category) use ($list) {
            $this->assertEquals("/categories/{$category->slug}", $list[$category->name]);
        });
    }
}