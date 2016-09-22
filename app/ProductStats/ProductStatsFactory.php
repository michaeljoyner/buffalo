<?php

namespace App\ProductStats;


use App\Products\Category;
use App\Products\Product;
use App\Products\ProductGroup;
use App\Products\Subcategory;

class ProductStatsFactory
{
    public static function make()
    {
        $totalProducts = Product::count();
        $categories = Category::count();
        $subcategories = Subcategory::count();
        $productGroups = ProductGroup::count();

        return new ProductStats($totalProducts, $categories, $subcategories, $productGroups);
    }
}