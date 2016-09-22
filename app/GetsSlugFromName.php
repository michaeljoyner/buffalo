<?php
/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 8/29/16
 * Time: 10:36 AM
 */

namespace App;


trait GetsSlugFromName
{
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}