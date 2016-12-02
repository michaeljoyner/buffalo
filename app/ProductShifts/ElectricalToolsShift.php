<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class ElectricalToolsShift extends ProductsShift
{
    public function execute()
    {
        $electrical = Category::where('name', 'Electrical Tools')->first();
        $oldVde = Category::where('name', 'VDE Tools')->first();

        $this->guardAgainstEmpty([$electrical, $oldVde]);

        $newVde = ProductOrganiser::getNewGroup($electrical, 'VDE Tools', $oldVde->description);

        ProductOrganiser::moveProducts($oldVde, $newVde);

        ProductOrganiser::pruneEmpty($oldVde);
    }


}