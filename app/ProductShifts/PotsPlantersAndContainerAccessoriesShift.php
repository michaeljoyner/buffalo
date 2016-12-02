<?php namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class PotsPlantersAndContainerAccessoriesShift extends ProductsShift
{
    public function execute()
    {
        $gardenCat = Category::where('name', 'Garden Tools')->first();
        $this->guardAgainstEmpty($gardenCat);

        $wateringTools = $gardenCat->subcategories()->where('name', 'Watering Tools')->first();
        $handTools = $gardenCat->subcategories()->where('name', 'Garden Hand Tools')->first();
        $this->guardAgainstEmpty([$wateringTools, $handTools]);

        $oldPots = $wateringTools->productGroups()->where('name', 'Pot')->first();
        $oldPlanters = $handTools->productGroups()->where('name', 'Planters')->first();
        $this->guardAgainstEmpty([$oldPots, $oldPlanters]);

        $ppaca = ProductOrganiser::getNewGroup($gardenCat, 'Pots, Planters and Container Accessories',
            'This is the Pots, planters and Container Accessories category');
        $newPots = ProductOrganiser::getNewGroup($ppaca, 'Pot', $oldPots->description);
        $newPlanters = ProductOrganiser::getNewGroup($ppaca, 'Planters', $oldPlanters->description);

        ProductOrganiser::moveProducts($oldPots, $newPots);
        ProductOrganiser::moveProducts($oldPlanters, $newPlanters);

        ProductOrganiser::pruneEmpty($oldPots);
        ProductOrganiser::pruneEmpty($oldPlanters);
    }
}