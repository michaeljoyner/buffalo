<?php

namespace App\Http\Controllers;

use App\Blog\Post;
use App\Products\Category;
use App\Products\Product;
use App\Products\ProductGroup;
use App\Products\ProductsRepository;
use App\Products\Subcategory;
use App\SiteContent\Slide;
use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
    public function home(ProductsRepository $productsRepository)
    {
        $slide = Slide::inOrder()->first(function($slide) {
            return $slide->is_published;
        });
        $products = $productsRepository->getRandom(8, false);
        $articles = Post::where('published', 1)->latest()->take(4)->get();
        return view('front.home.page')->with(compact('slide', 'products', 'articles'));
    }

    public function services()
    {
        return view('front.services.page');
    }

    public function about()
    {
        return view('front.about.page');
    }

    public function contact()
    {
        return view('front.contact.page');
    }



    public function cart()
    {
        return view('front.cart.page');
    }
}
