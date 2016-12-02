<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class AutomotiveShift extends ProductsShift
{
    public function execute()
    {
        $autoTools = Category::where('name', 'Automotive Tools')->first();
        $this->guardAgainstEmpty($autoTools);

        $engine = $autoTools->subcategories()->where('name', 'Engine')->first();
        $oldGearPuller = $autoTools->subcategories()->where('name', 'Gear Puller')->first();
        $oldTorqueWrench = $autoTools->subcategories()->where('name', 'Torque Wrench')->first();

        $this->guardAgainstEmpty([$engine, $oldGearPuller, $oldTorqueWrench]);

        $newGearPuller = ProductOrganiser::getNewGroup($engine, 'Gear Puller', $oldGearPuller->description);
        $newTorqueWrench = ProductOrganiser::getNewGroup($engine, 'Torque Wrench', $oldTorqueWrench->description);

        ProductOrganiser::moveProducts($oldGearPuller, $newGearPuller);
        ProductOrganiser::moveProducts($oldTorqueWrench, $newTorqueWrench);

        ProductOrganiser::pruneEmpty($oldGearPuller);
        ProductOrganiser::pruneEmpty($oldTorqueWrench);
    }
}