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

    public function searchAvailable($searchTerm)
    {
        $productCodeMatches = Product::with('category')->where('available', 1)->where('product_code', 'LIKE', $searchTerm)->get();
        $productNameMatches = Product::with('category')->where('available', 1)->where('name', 'LIKE', '%' . $searchTerm . '%')->get();

        return $productCodeMatches->merge($productNameMatches);
    }

    public function getRandom($count, $onlyAvailable = true)
    {
        $products = $onlyAvailable ? Product::where('is_available', 1)->get() : Product::all();

        if ($products->count() > 8) {
            return $products->random($count);
        }

        return $products;
    }

    public function relatedProducts(Product $product, $count = 4)
    {
        return RelatedProducts::query($product, $count);
    }


}