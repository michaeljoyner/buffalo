<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductGroup;
use App\Products\ProductOrganiser;

class ScrewdriverBitsShift extends ProductsShift
{
    public function execute()
    {
        $handTools = Category::where('name', 'Hand Tools')->first();
        $this->guardAgainstEmpty($handTools);

        $toolKits = $handTools->subcategories()->where('name', 'Tool kits')->first();
        $this->guardAgainstEmpty($toolKits);

        $oldBits = $toolKits->productGroups()->where('name', 'Bits Sets')->first();
        $this->guardAgainstEmpty($oldBits);

        $screwdrivers = ProductOrganiser::getNewGroup($handTools, 'Screwdriver & Bits Set', 'Screwdriver & Bits Set Tools');
        $newBits = ProductOrganiser::getNewGroup($screwdrivers, 'Bits Sets', $oldBits->description);

        ProductOrganiser::moveProducts($oldBits, $newBits);

        ProductOrganiser::pruneEmpty($oldBits);
    }
}