<?php


namespace App\ProductStats;


class ProductStats
{
    public $products;
    public $categories;
    public $subcategories;
    public $productGroups;

    public function __construct($products, $categories, $subcategories, $productGroups)
    {
        $this->products = $products;
        $this->categories = $categories;
        $this->subcategories = $subcategories;
        $this->productGroups = $productGroups;
    }
}