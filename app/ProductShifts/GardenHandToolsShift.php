<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class GardenHandToolsShift
{
    public static function execute()
    {
        $gardenTools = Category::where('name', 'Garden Tools')->first();

        $gardenHandToolsSub = $gardenTools->subcategories()->where('name', 'Garden Hand Tools')->first();

        if(! $gardenHandToolsSub) {
            throw new \Exception('Garden Hand Tools must exist');
        }

        $leafRakeSub = $gardenTools->subcategories()->where('name', 'Leaf Rake')->first();
        $gardenSawSub = $gardenTools->subcategories()->where('name', 'Garden Saw')->first();

        if(! $leafRakeSub || ! $gardenSawSub) {
            throw new \Exception('Leaf Rake and Garden Saw subs must exist');
        }

        $newLeafRake = ProductOrganiser::getNewGroup($gardenHandToolsSub, 'Leaf Rake', $leafRakeSub->description);
        $newGardenSaw = ProductOrganiser::getNewGroup($gardenHandToolsSub, 'Garden Saw', $gardenSawSub->description);

        ProductOrganiser::moveProducts($leafRakeSub, $newLeafRake);
        ProductOrganiser::moveProducts($gardenSawSub, $newGardenSaw);

        ProductOrganiser::pruneEmpty($gardenTools->subcategories()->withTrashed()->where('name', 'Leaf Rake')->first());
        ProductOrganiser::pruneEmpty($gardenTools->subcategories()->withTrashed()->where('name', 'Garden Saw')->first());
    }
}