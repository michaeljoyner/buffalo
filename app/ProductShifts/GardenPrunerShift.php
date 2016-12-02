<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class GardenPrunerShift
{
    public function execute()
    {
        $gardenCat = Category::where('name', 'Garden Tools')->first();
        $shearsAndScissors = $gardenCat->subcategories()->where('name', 'Garden Shears & Scissors')->first();
        $bypassPruner = $shearsAndScissors->productGroups()->where('name', 'Bypass Pruner')->first();
        $trimmingPruner = $shearsAndScissors->productGroups()->where('name', 'Trimming Pruner')->first();

        if(! $bypassPruner || ! $trimmingPruner) {
            throw new \Exception('Source groups not found');
        }

        $pruner = ProductOrganiser::getNewGroup($shearsAndScissors, 'Pruner', 'This is the Pruner Category');

        ProductOrganiser::moveProducts($bypassPruner, $pruner);
        ProductOrganiser::moveProducts($trimmingPruner, $pruner);

        ProductOrganiser::pruneEmpty($bypassPruner);
        ProductOrganiser::pruneEmpty($trimmingPruner);
    }
}