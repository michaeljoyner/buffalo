<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class AutomotiveShift
{
    public function execute()
    {
        $autoTools = Category::where('name', 'Automotive Tools')->first();

        if(! $autoTools) {
            throw new \Exception('No Automotive Tools');
        }

        $engine = $autoTools->subcategories()->where('name', 'Engine')->first();
        $oldGearPuller = $autoTools->subcategories()->where('name', 'Gear Puller')->first();
        $oldTorqueWrench = $autoTools->subcategories()->where('name', 'Torque Wrench')->first();

        if(! $oldGearPuller || ! $oldTorqueWrench) {
            throw new \Exception('Source groups not found');
        }

        $newGearPuller = ProductOrganiser::getNewGroup($engine, 'Gear Puller', $oldGearPuller->description);
        $newTorqueWrench = ProductOrganiser::getNewGroup($engine, 'Torque Wrench', $oldTorqueWrench->description);

        ProductOrganiser::moveProducts($oldGearPuller, $newGearPuller);
        ProductOrganiser::moveProducts($oldTorqueWrench, $newTorqueWrench);

        ProductOrganiser::pruneEmpty($oldGearPuller);
        ProductOrganiser::pruneEmpty($oldTorqueWrench);
    }
}