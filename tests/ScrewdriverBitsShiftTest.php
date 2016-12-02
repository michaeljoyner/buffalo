<?php


use App\Products\ProductGroup;
use App\Products\Subcategory;
use App\ProductShifts\ScrewdriverBitsShift;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ScrewdriverBitsShiftTest extends TestCase
{
    use DatabaseMigrations;

    protected $job;

    protected function setUp()
    {
        parent::setUp();
        $this->job = new ScrewdriverBitsShift();
    }

    /**
     *@test
     */
    public function it_shifts_the_bits_sets_to_the_correct_group()
    {
        $handTools = factory(\App\Products\Category::class)->create(['name' => 'Hand Tools']);
        $toolKits = $handTools->addSubcategory(['name' => 'Tool kits', 'description' => 'A sub cat']);
        $oldBits = $toolKits->addProductGroup(['name' => 'Bits Sets', 'description' => 'A prg']);

        foreach(range(1,10) as $index) {
            $oldBits->addProduct(['name' => 'Product ' . $index, 'product_code' => 'SBS_' . $index, 'description' => 'A product']);
        }

        $this->job->execute();

        $screwdiversAndBits = $handTools->subcategories()->where('name', 'Screwdriver & Bits Set')->first();
        $newBits = $screwdiversAndBits->productGroups()->where('name', 'Bits Sets')->first();

        $this->assertInstanceOf(Subcategory::class, $screwdiversAndBits);
        $this->assertInstanceOf(ProductGroup::class, $newBits);

        $this->assertCount(10, $newBits->products);

        $this->assertSoftDeleted($oldBits);
    }
}