<?php


namespace App\Products;


class ProductsRepository
{
    public function search($searchTerm)
    {
        $productCodeMatches = Product::with('category')->where('product_code', 'LIKE', $searchTerm)->get();
        $productNameMatches = Product::with('category')->where('name', 'LIKE', '%' . $searchTerm . '%')->get();

        return $productCodeMatches->merge($productNameMatches);
    }


}