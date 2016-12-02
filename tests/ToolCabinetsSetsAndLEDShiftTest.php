<?php


use App\Products\Subcategory;
use App\ProductShifts\ToolCabinetsSetsAndLEDShift;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ToolCabinetsSetsAndLEDShiftTest extends TestCase
{
    use DatabaseMigrations;

    protected $job;

    protected function setUp()
    {
        parent::setUp();

        $this->job = new ToolCabinetsSetsAndLEDShift();
    }

    /**
     *@test
     */
    public function it_shifts_the_tool_cabinets_sets_and_leds_correctly()
    {
        $handToolsCat = factory(\App\Products\Category::class)->create(['name' => 'Hand Tools']);
        $ledToolsCat = factory(\App\Products\Category::class)->create(['name' => 'LED Tools']);
        $toolCabinetsCat = factory(\App\Products\Category::class)->create(['name' => 'Tool Cabinets']);
        $toolSetsCat = factory(\App\Products\Category::class)->create(['name' => 'Tool Sets']);

        foreach(range(1,10) as $index) {
            $ledToolsCat->addProduct(['name' => 'Product ' . $index, 'product_code' => 'LED_' . $index, 'description' => 'A product']);
        }


        foreach(range(1,10) as $index) {
            $toolCabinetsCat->addProduct(['name' => 'Product ' . $index, 'product_code' => 'TC_' . $index, 'description' => 'A product']);
        }

        foreach(range(1,10) as $index) {
            $toolSetsCat->addProduct(['name' => 'Product ' . $index, 'product_code' => 'TS_' . $index, 'description' => 'A product']);
        }

        $this->job->execute();

        $newCabinets = $handToolsCat->subcategories()->where('name', 'Tool Cabinets')->first();
        $newSets = $handToolsCat->subcategories()->where('name', 'Tool Sets')->first();
        $newLED = $handToolsCat->subcategories()->where('name', 'LED Tools')->first();

        $this->assertInstanceOf(Subcategory::class, $newCabinets);
        $this->assertInstanceOf(Subcategory::class, $newSets);
        $this->assertInstanceOf(Subcategory::class, $newLED);

        $this->assertCount(10, $newCabinets->products);
        $this->assertCount(10, $newSets->products);
        $this->assertCount(10, $newLED->products);

        $this->assertSoftDeleted($toolCabinetsCat);
        $this->assertSoftDeleted($toolSetsCat);
        $this->assertSoftDeleted($ledToolsCat);

    }
}