<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class PlumbingToolsShift extends ProductsShift
{
    public function execute()
    {
        $handTools = Category::where('name', 'Hand Tools')->first();

        $this->guardAgainstEmpty($handTools);

        $oldRiveter = $handTools->subcategories()->where('name', 'Hand Riveter')->first();
        $oldPutty = $handTools->subcategories()->where('name', 'Putty Knife & Scraper')->first();
        $oldTrowel = $handTools->subcategories()->where('name', 'Trowel')->first();

        $this->guardAgainstEmpty([$oldRiveter, $oldPutty, $oldTrowel]);

        $plumbing = ProductOrganiser::getNewGroup($handTools, 'Plumbing & Building Tools', 'This is the plumbing and buidling tools category');
        $newRiveter = ProductOrganiser::getNewGroup($plumbing, 'Hand Riveter', $oldRiveter->description);
        $newPutty = ProductOrganiser::getNewGroup($plumbing, 'Putty Knife & Scraper', $oldPutty->description);
        $newTrowel = ProductOrganiser::getNewGroup($plumbing, 'Trowel', $oldTrowel->description);

        ProductOrganiser::moveProducts($oldRiveter, $newRiveter);
        ProductOrganiser::moveProducts($oldPutty, $newPutty);
        ProductOrganiser::moveProducts($oldTrowel, $newTrowel);

        ProductOrganiser::pruneEmpty($oldRiveter);
        ProductOrganiser::pruneEmpty($oldPutty);
        ProductOrganiser::pruneEmpty($oldTrowel);
    }
}