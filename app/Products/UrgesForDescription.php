<?php
/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/2/16
 * Time: 10:11 AM
 */

namespace App\Products;


trait UrgesForDescription
{
    public function getDescriptionAttribute($description)
    {
        if($description == "" || is_null($description)) {
            return 'This item has no description yet. This is important for SEO, please add a description as soon as possible.';
        }

        return $description;
    }
}