<?php

namespace App\Http\Controllers;

use App\Blog\Post;
use Illuminate\Http\Request;

use App\Http\Requests;

class NewsController extends Controller
{
    public function index()
    {
        $articles = Post::where('published', 1)->latest()->simplePaginate(10);
        return view('front.news.index')->with(compact('articles'));
    }

    public function show($slug)
    {
        $article = Post::where('published', 1)->where('slug', $slug)->firstOrFail();

        return view('front.news.article')->with(compact('article'));
    }
}
