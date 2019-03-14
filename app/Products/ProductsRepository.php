<?php


namespace App\Products;


use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ProductsRepository
{
    public function search($searchTerm)
    {
        $factoryNumberMatches = Product::whereHas('supplies', function($query) use ($searchTerm) {
            $query->where('item_number', 'LIKE', '%' . $searchTerm . '%');
        })->with(['supplies' => function($q) use ($searchTerm) {
            $q->where('item_number', 'LIKE', '%' . $searchTerm . '%');
        }])->get();
        $productCodeMatches = Product::with('category')->where('product_code', 'LIKE', '%' . $searchTerm . '%')->get();
        $productNameMatches = Product::with('category')->where('name', 'LIKE', '%' . $searchTerm . '%')->get();

        return $factoryNumberMatches->merge($productCodeMatches->merge($productNameMatches))->map(function($product) {
            return [
              'id' => $product->id,
                'product_code' => $product->product_code,
                'name' => $product->name,
                'product_category' => $product->category->name,
                'thumb_img' => $product->imageSrc('thumb'),
                'factory_number' => $product->supplies->first()->item_number ?? null,
            ];
        });
    }

    public function searchAvailable($searchTerm)
    {
        $productCodeMatches = Product::with('category')->where('available', 1)->where('product_code', 'LIKE',
            '%' . $searchTerm . '%')->get();
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
        $today = Carbon::now()->format('Y-m-d');
        return Cache::remember('products.featured', 3600, function () use ($quantity, $today) {
            $promoted = Product::whereNotNull('promoted_until')->where('promoted_until', '>=', $today)->where('available', 1)->get();
            if ($promoted->count() < $quantity) {
                $filler = Product::where('is_promoted', 0)->where('available', 1)
                    ->get()->shuffle()->take($quantity - $promoted->count());

                return $promoted->merge($filler)->shuffle()->sortByDesc('promoted_until')->values();
            }

            return $promoted->shuffle()->take($quantity)->sortByDesc('promoted_until')->values();
        });
    }


}