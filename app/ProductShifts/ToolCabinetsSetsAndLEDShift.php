<?php


namespace App\ProductShifts;


use App\Products\Category;

class ToolCabinetsSetsAndLEDShift
{
    public function execute()
    {
        $handTools = Category::where('name', 'Hand Tools')->first();
    }
}