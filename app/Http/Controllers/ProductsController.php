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
        $categories = Category::withCount('products')->get();

        return view('front.categories.page')->with(compact('categories'));
    }

    public function category($slug)
    {
        $category = Category::with('subcategories.productGroups')->where('slug', $slug)->firstOrFail();
        $products = $category->products()->paginate(18);

        return view('front.category.page')->with(compact('category', 'products'));
    }

    public function subcategory($slug)
    {
        $subcategory = Subcategory::with('productGroups')->where('slug', $slug)->firstOrFail();
        $products = $subcategory->products()->paginate(18);

        return view('front.category.subcategory')->with(compact('subcategory', 'products'));
    }

    public function productGroups($slug)
    {
        $productGroup = ProductGroup::where('slug', $slug)->firstOrFail();
        $products = $productGroup->products()->paginate(18);

        return view('front.category.productgroup')->with(compact('productGroup', 'products'));
    }

    public function product($slug, ProductsRepository $productsRepository)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = $productsRepository->relatedProducts($product);

        return view('front.product.page')->with(compact('product', 'relatedProducts'));
    }
}