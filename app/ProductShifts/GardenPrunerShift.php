<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class GardenPrunerShift extends ProductsShift
{
    public function execute()
    {
        $gardenCat = Category::where('name', 'Garden Tools')->first();
        $this->guardAgainstEmpty($gardenCat);
        $shearsAndScissors = $gardenCat->subcategories()->where('name', 'Garden Shears & Scissors')->first();
        $this->guardAgainstEmpty($shearsAndScissors);

        $bypassPruner = $shearsAndScissors->productGroups()->where('name', 'Bypass Pruner')->first();
        $trimmingPruner = $shearsAndScissors->productGroups()->where('name', 'Trimming Pruner')->first();
        $this->guardAgainstEmpty([$bypassPruner, $trimmingPruner]);

        $pruner = ProductOrganiser::getNewGroup($shearsAndScissors, 'Pruner', 'This is the Pruner Category');

        ProductOrganiser::moveProducts($bypassPruner, $pruner);
        ProductOrganiser::moveProducts($trimmingPruner, $pruner);

        ProductOrganiser::pruneEmpty($bypassPruner);
        ProductOrganiser::pruneEmpty($trimmingPruner);
    }
}