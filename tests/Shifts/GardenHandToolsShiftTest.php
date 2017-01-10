<?php


use App\Products\ProductGroup;
use App\ProductShifts\GardenHandToolsShift;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GardenHandToolsShiftTest extends TestCase
{
    use DatabaseMigrations;

    protected $job;

    protected function setUp()
    {
        parent::setUp();
        $this->job = new GardenHandToolsShift();
    }

    /**
     *@test
     */
    public function it_executes_the_garden_hand_tools_job()
    {
        //Setup world
        $gardenToolsCat = factory(\App\Products\Category::class)->create(['name' => 'Garden Tools']);
        $gardenHandToolsSub = $gardenToolsCat->addSubcategory(['name' => 'Garden Hand Tools', 'description' => 'A description']);
        $leafRakeSub = $gardenToolsCat->addSubcategory(['name' => 'Leaf Rake', 'description' => 'A description']);
        $gardenSawSub = $gardenToolsCat->addSubcategory(['name' => 'Garden Saw', 'description' => 'A description']);

        foreach(range(1,10) as $index) {
            $leafRakeSub->addProduct(['name' => 'Product ' . $index, 'product_code' => 'LR_' . $index, 'description' => 'A product']);
        }


        foreach(range(1,10) as $index) {
            $gardenSawSub->addProduct(['name' => 'Product ' . $index, 'product_code' => 'GS' . $index, 'description' => 'A product']);
        }

        //Execute
        $this->job->execute();

        //Assert
        $newLeafRake = $gardenHandToolsSub->productGroups()->where('name', 'Leaf Rake')->first();
        $newGardenSaw = $gardenHandToolsSub->productGroups()->where('name', 'Garden Saw')->first();
        $this->assertInstanceOf(ProductGroup::class, $newLeafRake);
        $this->assertInstanceOf(ProductGroup::class, $newGardenSaw);

        $this->assertCount(10, $newLeafRake->products);
        $this->assertCount(10, $newGardenSaw->products);

        $this->assertSoftDeleted($leafRakeSub);
        $this->assertSoftDeleted($gardenSawSub);
    }
}