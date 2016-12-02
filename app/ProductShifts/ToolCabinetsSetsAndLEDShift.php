<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class ToolCabinetsSetsAndLEDShift extends ProductsShift
{
    public function execute()
    {
        $handTools = Category::where('name', 'Hand Tools')->first();
        $this->guardAgainstEmpty($handTools);

        $oldCabinets = Category::where('name', 'Tool Cabinets')->first();
        $oldSets = Category::where('name', 'Tool Sets')->first();
        $oldLed = Category::where('name', 'LED Tools')->first();
        $this->guardAgainstEmpty([$oldCabinets, $oldSets, $oldLed]);


        $newCabinets = ProductOrganiser::getNewGroup($handTools, 'Tool Cabinets', $oldCabinets->description);
        $newSets = ProductOrganiser::getNewGroup($handTools, 'Tool Sets', $oldSets->description);
        $newLed = ProductOrganiser::getNewGroup($handTools, 'LED Tools', $oldLed->description);

        ProductOrganiser::moveProducts($oldCabinets, $newCabinets);
        ProductOrganiser::moveProducts($oldSets, $newSets);
        ProductOrganiser::moveProducts($oldLed, $newLed);

        ProductOrganiser::pruneEmpty($oldCabinets);
        ProductOrganiser::pruneEmpty($oldSets);
        ProductOrganiser::pruneEmpty($oldLed);
    }
}