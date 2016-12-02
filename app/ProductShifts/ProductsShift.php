<?php


namespace App\ProductShifts;


abstract class ProductsShift
{
    abstract public function execute();

    protected function guardAgainstEmpty($group)
    {
        if(! is_array($group)) {
            $group = [$group];
        }

        foreach($group as $object) {
            if(! $object) {
                throw new \Exception('Source group not found');
            }
        }
    }
}