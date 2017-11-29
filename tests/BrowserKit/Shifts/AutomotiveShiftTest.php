<?php


use App\Products\Category;
use App\Products\ProductGroup;
use App\ProductShifts\AutomotiveShift;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AutomotiveShiftTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $job;

    protected function setUp()
    {
        parent::setUp();
        $this->job = new AutomotiveShift();
    }

    /**
     *@test
     */
    public function it_correctly_shifts_the_automotive_tools()
    {
        $autoTools = factory(Category::class)->create(['name' => 'Automotive Tools']);
        $engineSub = $autoTools->addSubcategory(['name' => 'Engine', 'description' => 'A sub cat']);
        $oldGearPuller = $autoTools->addSubcategory(['name' => 'Gear Puller', 'description' => 'A sub cat']);
        $oldTorqueWrench = $autoTools->addSubcategory(['name' => 'Torque Wrench', 'description' => 'A sub cat']);

        foreach(range(1,10) as $index) {
            $oldGearPuller->addProduct(['name' => 'Product ' . $index, 'product_code' => 'GP_' . $index, 'description' => 'A product']);
        }


        foreach(range(1,10) as $index) {
            $oldTorqueWrench->addProduct(['name' => 'Product ' . $index, 'product_code' => 'TW_' . $index, 'description' => 'A product']);
        }

        $this->job->execute();


        $newGearPuller = $engineSub->productGroups()->where('name', 'Gear Puller')->first();
        $newTorqueWrench = $engineSub->productGroups()->where('name', 'Torque Wrench')->first();

        $this->assertInstanceOf(ProductGroup::class, $newGearPuller);
        $this->assertInstanceOf(ProductGroup::class, $newTorqueWrench);


        $this->assertCount(10, $newGearPuller->products);
        $this->assertCount(10, $newTorqueWrench->products);

        $this->assertSoftDeleted($oldGearPuller);
        $this->assertSoftDeleted($oldTorqueWrench);
    }
}