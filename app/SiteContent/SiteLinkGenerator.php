<?php


namespace App\SiteContent;


use App\Products\Category;

class SiteLinkGenerator
{
    const BASIC_PAGES = [
        'About page' => '/about',
        'Services page' => '/services',
        'Products page' => '/categories',
        'Contact page' => '/contact'
    ];

    public static function generate()
    {
        return array_merge(static::BASIC_PAGES, static::getCategoryLinks());
    }

    protected static function getCategoryLinks()
    {
        return Category::all()->flatMap(function($category) {
            return [$category->name => '/categories/' . $category->slug];
        })->toArray();
    }


}