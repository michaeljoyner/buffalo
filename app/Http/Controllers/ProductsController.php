<?php

namespace App\Http\Controllers;

use App\Products\Category;
use App\Products\Product;
use App\Products\ProductGroup;
use App\Products\ProductsRepository;
use App\Products\Subcategory;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProductsController extends Controller
{
    public function categories()
    {
        $categories = Category::getOrdered();

        return view('front.categories.page')->with(compact('categories'));
    }

    public function category($slug)
    {
        $category = $this->fetchLoadedCategory(Category::where('slug', $slug));
        $products = $category->products()->orderBy('new_until', 'desc')->latest()->paginate(18);

        return view('front.category.page')->with(compact('category', 'products'));
    }

    public function subcategory($slug)
    {
        $subcategory = Subcategory::with('productGroups')->where('slug', $slug)->firstOrFail();
        $category = $this->fetchLoadedCategory($subcategory->category());
        $products = $subcategory->products()->orderBy('new_until', 'desc')->latest()->paginate(18);

        return view('front.category.subcategory')->with(compact('subcategory', 'products', 'category'));
    }

    public function productGroups($slug)
    {
        $productGroup = ProductGroup::where('slug', $slug)->firstOrFail();
        $products = $productGroup->products()->orderBy('new_until', 'desc')->latest()->paginate(18);
        $category = $this->fetchLoadedCategory($productGroup->subcategory->category());

        return view('front.category.productgroup')->with(compact('productGroup', 'products', 'category'));
    }

    public function product($slug, ProductsRepository $productsRepository)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = $productsRepository->relatedProducts($product);

        return view('front.product.page')->with(compact('product', 'relatedProducts'));
    }

    protected function fetchLoadedCategory($hasCategory)
    {
        return $hasCategory->with(['subcategories' => function($query) {
            return $query->with('productGroups')->orderBy('name');
        }])->firstOrFail();
    }
}
