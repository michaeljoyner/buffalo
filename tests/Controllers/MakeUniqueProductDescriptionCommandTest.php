<?php


use Illuminate\Foundation\Testing\DatabaseMigrations;

class MakeUniqueProductDescriptionCommandTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function product_descriptions_are_made_unique_by_adding_product_code_via_artisan_command()
    {
        $product = factory(\App\Products\Product::class)->create([
            'name'         => 'Test Product',
            'product_code' => 'TEST001',
            'description' => 'Test Product - a Buffalo Tools product in our Handheld category'
        ]);

        $expected = 'Test Product (TEST001) - a Buffalo Tools product in our Handheld category';

        \Illuminate\Support\Facades\Artisan::call('products:describe_unique');

        $this->assertEquals($expected, $product->fresh()->description);
    }

    /**
     *@test
     */
    public function a_product_description_without_the_name_will_not_be_altered()
    {
        $product = factory(\App\Products\Product::class)->create([
            'name'         => 'Test Product',
            'product_code' => 'TEST001',
            'description' => 'This presumably unique description does not actually contain the product name'
        ]);

        $expected = 'This presumably unique description does not actually contain the product name';

        \Illuminate\Support\Facades\Artisan::call('products:describe_unique');

        $this->assertEquals($expected, $product->fresh()->description);
    }

    /**
     *@test
     */
    public function a_description_that_already_contains_the_product_code_will_not_be_changed()
    {
        $product = factory(\App\Products\Product::class)->create([
            'name'         => 'Test Product',
            'product_code' => 'TEST001',
            'description' => 'TEST001, or more casually known as Test Product is one hell of a tool, said she'
        ]);

        $expected = 'TEST001, or more casually known as Test Product is one hell of a tool, said she';

        \Illuminate\Support\Facades\Artisan::call('products:describe_unique');

        $this->assertEquals($expected, $product->fresh()->description);
    }
}