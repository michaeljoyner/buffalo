<?php


namespace App\Products;


use Illuminate\Support\Facades\Cache;

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
        $productCodeMatches = Product::with('category')->where('available', 1)->where('product_code', 'LIKE',
            $searchTerm)->get();
        $productNameMatches = Product::with('category')->where('available', 1)->where('name', 'LIKE',
            '%' . $searchTerm . '%')->get();

        return $productCodeMatches->merge($productNameMatches);
    }

    public function getRandom($count, $onlyAvailable = true)
    {
        $products = $onlyAvailable ? Product::where('available', 1)->get() : Product::all();

        if ($products->count() > $count) {
            return $products->random($count);
        }

        return $products;
    }

    public function relatedProducts(Product $product, $count = 4)
    {
        return RelatedProducts::query($product, $count);
    }

    public function featuredProducts($quantity = 8)
    {
        return Cache::remember('products.featured', 60 * 24, function () use ($quantity) {
            $promoted = Product::where('is_promoted', 1)->where('available', 1)->get();
            if ($promoted->count() < $quantity) {
                $filler = Product::where('is_promoted', 0)->where('available', 1)
                    ->get()->shuffle()->take($quantity - $promoted->count());

                return $promoted->merge($filler)->shuffle();
            }

            return $promoted->shuffle()->take($quantity);
        });
    }


}