<?php


use App\Products\Category;
use App\Products\ProductGroup;
use App\Products\Subcategory;
use App\ProductShifts\CuttingToolsShift;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CuttingToolsShiftTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $job;

    protected function setUp(): void
    {
        parent::setUp();
        $this->job = new CuttingToolsShift();
    }

    /**
     *@test
     */
    public function it_shifts_the_cutting_tools_correctly()
    {
        $handTools = factory(Category::class)->create(['name' => 'Hand Tools']);
        $oldCutter = $handTools->addSubcategory(['name' => 'Cutter', 'description' => 'A sub cat']);
        $oldFile = $handTools->addSubcategory(['name' => 'File', 'description' => 'A sub cat']);
        $oldKnive = $handTools->addSubcategory(['name' => 'Knife', 'description' => 'A sub cat']);
        $oldKniveBlades = $oldKnive->addProductGroup(['name' => 'Knife Blades', 'description' => 'A prg']);
        $oldSaw = $handTools->addSubcategory(['name' => 'Saw', 'description' => 'A sub cat']);
        $oldScissors = $handTools->addSubcategory(['name' => 'Scissors', 'description' => 'A sub cat']);

        foreach(range(1,10) as $index) {
            $oldCutter->addProduct(['name' => 'Product ' . $index, 'product_code' => 'CU_' . $index, 'description' => 'A product']);
        }


        foreach(range(1,10) as $index) {
            $oldFile->addProduct(['name' => 'Product ' . $index, 'product_code' => 'FI_' . $index, 'description' => 'A product']);
        }

        foreach(range(1,6) as $index) {
            $oldKnive->addProduct(['name' => 'Product ' . $index, 'product_code' => 'KN_' . $index, 'description' => 'A product']);
        }

        foreach(range(1,4) as $index) {
            $oldKniveBlades->addProduct(['name' => 'Product ' . $index, 'product_code' => 'KNB_' . $index, 'description' => 'A product']);
        }

        foreach(range(1,10) as $index) {
            $oldSaw->addProduct(['name' => 'Product ' . $index, 'product_code' => 'SA_' . $index, 'description' => 'A product']);
        }


        foreach(range(1,10) as $index) {
            $oldScissors->addProduct(['name' => 'Product ' . $index, 'product_code' => 'SC_' . $index, 'description' => 'A product']);
        }

        $this->job->execute();

        $cutting = $handTools->subcategories()->where('name', 'Cutting & Finishing')->first();
        $newCutter = $cutting->productGroups()->where('name', 'Cutter')->first();
        $newFile = $cutting->productGroups()->where('name', 'File')->first();
        $newKnive = $cutting->productGroups()->where('name', 'Knife')->first();
        $newSaw = $cutting->productGroups()->where('name', 'Saw')->first();
        $newScissors = $cutting->productGroups()->where('name', 'Scissors')->first();

        $this->assertInstanceOf(Subcategory::class, $cutting);
        $this->assertInstanceOf(ProductGroup::class, $newCutter);
        $this->assertInstanceOf(ProductGroup::class, $newFile);
        $this->assertInstanceOf(ProductGroup::class, $newKnive);
        $this->assertInstanceOf(ProductGroup::class, $newSaw);
        $this->assertInstanceOf(ProductGroup::class, $newScissors);

        $this->assertCount(10, $newCutter->products);
        $this->assertCount(10, $newFile->products);
        $this->assertCount(10, $newKnive->products);
        $this->assertCount(10, $newSaw->products);
        $this->assertCount(10, $newScissors->products);

        $this->assertSoftDeleted($oldCutter);
        $this->assertSoftDeleted($oldFile);
        $this->assertSoftDeleted($oldKnive);
        $this->assertSoftDeleted($oldSaw);
        $this->assertSoftDeleted($oldScissors);
    }
}