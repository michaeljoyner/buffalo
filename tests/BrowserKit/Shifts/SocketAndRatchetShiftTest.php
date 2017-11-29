<?php


use App\Products\Category;
use App\ProductShifts\SocketAndRatchetShift;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SocketAndRatchetShiftTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $job;

    protected function setUp()
    {
        parent::setUp();
        $this->job = new SocketAndRatchetShift();
    }

    /**
     *@test
     */
    public function it_shifts_the_sockets_and_ratchets_correctly()
    {
        $handTools = factory(Category::class)->create(['name' => 'Hand Tools']);
        $oldSockets = factory(Category::class)->create(['name' => 'Sockets']);
        $oldRatchetHandles = $handTools->addSubcategory(['name' => 'Ratchet Handles', 'description' => 'A sub cat']);
        $toolKits = $handTools->addSubcategory(['name' => 'Tool kits', 'description' => 'A sub cat']);
        $oldRatchetSets = $toolKits->addProductGroup(['name' => 'Ratchet Sets', 'description' => 'A prg']);

        foreach(range(1,10) as $index) {
            $oldSockets->addProduct(['name' => 'Product ' . $index, 'product_code' => 'SO_' . $index, 'description' => 'A product']);
        }

        foreach(range(1,10) as $index) {
            $oldRatchetHandles->addProduct(['name' => 'Product ' . $index, 'product_code' => 'RH_' . $index, 'description' => 'A product']);
        }

        foreach(range(1,10) as $index) {
            $oldRatchetSets->addProduct(['name' => 'Product ' . $index, 'product_code' => 'RS_' . $index, 'description' => 'A product']);
        }

        $this->job->execute();

        $socketAndRatchet = $handTools->subcategories()->where('name', 'Socket & Ratchet')->first();
        $newSockets = $socketAndRatchet->productGroups()->where('name', 'Sockets')->first();
        $newRatchetHandles = $socketAndRatchet->productGroups()->where('name', 'Ratchet Handles')->first();
        $newRatchetSets = $socketAndRatchet->productGroups()->where('name', 'Ratchet Sets')->first();

        $this->assertInstanceOf(\App\Products\Subcategory::class, $socketAndRatchet);
        $this->assertInstanceOf(\App\Products\ProductGroup::class, $newSockets);
        $this->assertInstanceOf(\App\Products\ProductGroup::class, $newRatchetHandles);
        $this->assertInstanceOf(\App\Products\ProductGroup::class, $newRatchetSets);

        $this->assertCount(10, $newSockets->products);
        $this->assertCount(10, $newRatchetHandles->products);
        $this->assertCount(10, $newRatchetSets->products);

        $this->assertSoftDeleted($oldSockets);
        $this->assertSoftDeleted($oldRatchetHandles);
        $this->assertSoftDeleted($oldRatchetSets);
    }
}