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
        $oldKnive = $handTools->subcategories()->where('name', 'Knive')->first();
        $oldSaw = $handTools->subcategories()->where('name', 'Saw')->first();
        $oldScissors = $handTools->subcategories()->where('name', 'Scissors')->first();

        $this->guardAgainstEmpty([$oldCutter, $oldFile, $oldKnive, $oldSaw, $oldScissors]);

        $cutting = ProductOrganiser::getNewGroup($handTools, 'Cutting & Finishing', 'Cutting and Finishing Tools');
        $newCutter = ProductOrganiser::getNewGroup($cutting, 'Cutter', $oldCutter->description);
        $newFile = ProductOrganiser::getNewGroup($cutting, 'File', $oldFile->description);
        $newKnive = ProductOrganiser::getNewGroup($cutting, 'Knive', $oldKnive->description);
        $newSaw = ProductOrganiser::getNewGroup($cutting, 'Saw', $oldSaw->description);
        $newScissors = ProductOrganiser::getNewGroup($cutting, 'Scissors', $oldScissors->description);

        ProductOrganiser::moveProducts($oldCutter, $newCutter);
        ProductOrganiser::moveProducts($oldFile, $newFile);
        ProductOrganiser::moveProducts($oldKnive, $newKnive);
        ProductOrganiser::moveProducts($oldSaw, $newSaw);
        ProductOrganiser::moveProducts($oldScissors, $newScissors);

        ProductOrganiser::pruneEmpty($oldCutter);
        ProductOrganiser::pruneEmpty($oldFile);
        ProductOrganiser::pruneEmpty($oldKnive);
        ProductOrganiser::pruneEmpty($oldSaw);
        ProductOrganiser::pruneEmpty($oldScissors);
    }
}