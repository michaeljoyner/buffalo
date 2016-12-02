<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class GardenHandToolsShift extends ProductsShift
{
    public function execute()
    {
        $gardenTools = Category::where('name', 'Garden Tools')->first();
        $this->guardAgainstEmpty($gardenTools);

        $gardenHandToolsSub = $gardenTools->subcategories()->where('name', 'Garden Hand Tools')->first();
        $this->guardAgainstEmpty($gardenHandToolsSub);

        $leafRakeSub = $gardenTools->subcategories()->where('name', 'Leaf Rake')->first();
        $gardenSawSub = $gardenTools->subcategories()->where('name', 'Garden Saw')->first();
        $this->guardAgainstEmpty([$leafRakeSub, $gardenSawSub]);

        $newLeafRake = ProductOrganiser::getNewGroup($gardenHandToolsSub, 'Leaf Rake', $leafRakeSub->description);
        $newGardenSaw = ProductOrganiser::getNewGroup($gardenHandToolsSub, 'Garden Saw', $gardenSawSub->description);

        ProductOrganiser::moveProducts($leafRakeSub, $newLeafRake);
        ProductOrganiser::moveProducts($gardenSawSub, $newGardenSaw);

        ProductOrganiser::pruneEmpty($gardenTools->subcategories()->withTrashed()->where('name', 'Leaf Rake')->first());
        ProductOrganiser::pruneEmpty($gardenTools->subcategories()->withTrashed()->where('name', 'Garden Saw')->first());
    }
}