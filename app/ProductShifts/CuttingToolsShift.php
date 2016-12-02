<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class CuttingToolsShift extends ProductsShift
{
    public function execute()
    {
        $handTools = Category::where('name', 'Hand Tools')->first();
        $this->guardAgainstEmpty($handTools);

        $oldCutter = $handTools->subcategories()->where('name', 'Cutter')->first();
        $oldFile = $handTools->subcategories()->where('name', 'File')->first();
        $oldKnife = $handTools->subcategories()->where('name', 'Knife')->first();
        $oldSaw = $handTools->subcategories()->where('name', 'Saw')->first();
        $oldScissors = $handTools->subcategories()->where('name', 'Scissors')->first();

        $this->guardAgainstEmpty([$oldCutter, $oldFile, $oldKnife, $oldSaw, $oldScissors]);

        $cutting = ProductOrganiser::getNewGroup($handTools, 'Cutting & Finishing', 'Cutting and Finishing Tools');
        $newCutter = ProductOrganiser::getNewGroup($cutting, 'Cutter', $oldCutter->description);
        $newFile = ProductOrganiser::getNewGroup($cutting, 'File', $oldFile->description);
        $newKnife = ProductOrganiser::getNewGroup($cutting, 'Knife', $oldKnife->description);
        $newSaw = ProductOrganiser::getNewGroup($cutting, 'Saw', $oldSaw->description);
        $newScissors = ProductOrganiser::getNewGroup($cutting, 'Scissors', $oldScissors->description);

        ProductOrganiser::moveProducts($oldCutter, $newCutter);
        ProductOrganiser::moveProducts($oldFile, $newFile);
        ProductOrganiser::moveProducts($oldKnife, $newKnife);
        ProductOrganiser::moveProducts($oldSaw, $newSaw);
        ProductOrganiser::moveProducts($oldScissors, $newScissors);

        ProductOrganiser::pruneEmpty($oldCutter);
        ProductOrganiser::pruneEmpty($oldFile);
        ProductOrganiser::pruneEmpty($oldKnife);
        ProductOrganiser::pruneEmpty($oldSaw);
        ProductOrganiser::pruneEmpty($oldScissors);
    }
}