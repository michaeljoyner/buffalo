<?php


use App\Products\Category;
use App\ProductShifts\GardenPrunerShift;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GardenPrunerShiftTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $job;

    protected function setUp(): void
    {
        parent::setUp();
        $this->job = new GardenPrunerShift();
    }

    /**
     *@test
     */
    public function it_shifts_the_bypass_and_trimming_pruners_correctly()
    {
        $gardenCat = factory(Category::class)->create(['name' => 'Garden Tools']);
        $shearsAndScissors = $gardenCat->addSubcategory(['name' => 'Garden Shears & Scissors', 'description' => 'A sub cat']);
        $bypassPruner = $shearsAndScissors->addProductGroup(['name' => 'Bypass Pruner', 'description' => 'A prg']);
        $trimmingPruner = $shearsAndScissors->addProductGroup(['name' => 'Trimming Pruner', 'description' => 'A prg']);
        $pruners = $shearsAndScissors->addProductGroup(['name' => 'Pruner', 'description' => 'A prg']);

        foreach(range(1,10) as $index) {
            $bypassPruner->addProduct(['name' => 'Product ' . $index, 'product_code' => 'BY_' . $index, 'description' => 'A product']);
        }


        foreach(range(1,10) as $index) {
            $trimmingPruner->addProduct(['name' => 'Product ' . $index, 'product_code' => 'TR_' . $index, 'description' => 'A product']);
        }

        $this->job->execute();

        $this->assertCount(20, $pruners->products);

        $this->assertSoftDeleted($bypassPruner);
        $this->assertSoftDeleted($trimmingPruner);
    }
}