<?php


use App\ProductShifts\ElectricalToolsShift;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ElectricalToolsShiftTest extends TestCase
{
    use DatabaseMigrations;

    protected $job;

    protected function setUp()
    {
        parent::setUp();
        $this->job = new ElectricalToolsShift();
    }

    /**
     *@test
     */
    public function it_shifts_the_vde_tools_correctly()
    {
        $electrical = factory(\App\Products\Category::class)->create(['name' => 'Electrical Tools']);
        $oldVde = factory(\App\Products\Category::class)->create(['name' => 'VDE Tools']);

        foreach(range(1,10) as $index) {
            $oldVde->addProduct(['name' => 'Product ' . $index, 'product_code' => 'VDE_' . $index, 'description' => 'A product']);
        }

        $this->job->execute();

        $newVde = $electrical->subcategories()->where('name', 'VDE Tools')->first();

        $this->assertInstanceOf(\App\Products\Subcategory::class, $newVde);

        $this->assertCount(10, $newVde->products);

        $this->assertSoftDeleted($oldVde);
    }
}