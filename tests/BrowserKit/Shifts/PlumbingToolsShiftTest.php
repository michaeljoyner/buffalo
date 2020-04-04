<?php


use App\Products\Category;
use App\Products\ProductGroup;
use App\Products\Subcategory;
use App\ProductShifts\PlumbingToolsShift;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PlumbingToolsShiftTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $job;

    protected function setUp(): void
    {
        parent::setUp();
        $this->job = new PlumbingToolsShift();
    }

    /**
     *@test
     */
    public function it_correctly_shifts_the_plumbing_tools()
    {
        $handTools = factory(Category::class)->create(['name' => 'Hand Tools']);
        $handRiveter = $handTools->addSubcategory(['name' => 'Hand Riveter', 'description' => 'A sub cat']);
        $puttyKnife = $handTools->addSubcategory(['name' => 'Putty Knife & Scraper', 'description' => 'A sub cat']);
        $trowel = $handTools->addSubcategory(['name' => 'Trowel', 'description' => 'A sub cat']);

        foreach(range(1,10) as $index) {
            $handRiveter->addProduct(['name' => 'Product ' . $index, 'product_code' => 'HR_' . $index, 'description' => 'A product']);
        }


        foreach(range(1,10) as $index) {
            $puttyKnife->addProduct(['name' => 'Product ' . $index, 'product_code' => 'PK_' . $index, 'description' => 'A product']);
        }

        foreach(range(1,10) as $index) {
            $trowel->addProduct(['name' => 'Product ' . $index, 'product_code' => 'TR_' . $index, 'description' => 'A product']);
        }

        $this->job->execute();

        $plumbing = $handTools->subcategories()->where('name', 'Plumbing & Building Tools')->first();
        $newRiveter = $plumbing->productGroups()->where('name', 'Hand Riveter')->first();
        $newPutty = $plumbing->productGroups()->where('name', 'Putty Knife & Scraper')->first();
        $newTrowel = $plumbing->productGroups()->where('name', 'Trowel')->first();

        $this->assertInstanceOf(Subcategory::class, $plumbing);
        $this->assertInstanceOf(ProductGroup::class, $newRiveter);
        $this->assertInstanceOf(ProductGroup::class, $newPutty);
        $this->assertInstanceOf(ProductGroup::class, $newTrowel);

        $this->assertCount(10, $newRiveter->products);
        $this->assertCount(10, $newPutty->products);
        $this->assertCount(10, $newTrowel->products);

        $this->assertSoftDeleted($handRiveter);
        $this->assertSoftDeleted($puttyKnife);
        $this->assertSoftDeleted($trowel);
    }
}