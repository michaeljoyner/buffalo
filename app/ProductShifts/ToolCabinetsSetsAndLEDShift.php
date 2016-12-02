<?php


namespace App\ProductShifts;


use App\Products\Category;

class ToolCabinetsSetsAndLEDShift
{
    public function execute()
    {
        $handTools = Category::where('name', 'Hand Tools')->first();

        $oldCabinets = Category::where('name', 'Tool Cabinets')->first();
        $oldSets = Category::where('name', 'Tool Sets')->first();
        $oldLed = Category::where('name', 'LED Tools')->first();


    }
}