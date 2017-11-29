<?php


use App\Products\Category;
use App\ProductShifts\PotsPlantersAndContainerAccessoriesShift;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PotsPlantersAndContainerAccessoriesShiftTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $job;

    protected function setUp()
    {
        parent::setUp();
        $this->job = new PotsPlantersAndContainerAccessoriesShift();
    }

    /**
     *@test
     */
    public function it_shifts_the_pots_planters_and_container_accessories_as_required()
    {
        $gardenCat = factory(Category::class)->create(['name' => 'Garden Tools']);
        $ppacaSub = $gardenCat->addSubcategory(['name' => 'Pots, Planters and Container Accessories', 'description' => 'A sub cat']);
        $wateringTools = $gardenCat->addSubcategory(['name' => 'Watering Tools', 'description' => 'A sub cat']);
        $gardenHand = $gardenCat->addSubcategory(['name' => 'Garden Hand Tools', 'description' => 'A sub cat']);
        $oldPotsPrg = $wateringTools->addProductGroup(['name' => 'Pot', 'description' => 'A product group']);
        $oldPlantersPrg = $gardenHand->addProductGroup(['name' => 'Planters', 'description' => 'A product group']);

        foreach(range(1,10) as $index) {
            $oldPotsPrg->addProduct(['name' => 'Product ' . $index, 'product_code' => 'PO_' . $index, 'description' => 'A product']);
        }


        foreach(range(1,10) as $index) {
            $oldPlantersPrg->addProduct(['name' => 'Product ' . $index, 'product_code' => 'PL' . $index, 'description' => 'A product']);
        }

        $this->job->execute();

        $newPotsPrg = $ppacaSub->productGroups()->where('name', 'Pot')->first();
        $newPlantersPrg = $ppacaSub->productGroups()->where('name', 'Planters')->first();
        $this->assertInstanceOf(\App\Products\ProductGroup::class, $newPotsPrg);
        $this->assertInstanceOf(\App\Products\ProductGroup::class, $newPlantersPrg);

        $this->assertCount(10, $newPotsPrg->products);
        $this->assertCount(10, $newPlantersPrg->products);

        $this->assertSoftDeleted($oldPotsPrg);
        $this->assertSoftDeleted($oldPlantersPrg);
    }
}