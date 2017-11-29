<?php

namespace App\Http\Controllers\Admin;

use App\Products\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryBannerImageController extends Controller
{

    public function edit(Category $category)
    {
        return view('admin.categories.banner.edit')->with(compact('category'));
    }

    public function store(Request $request, Category $category)
    {
        $this->validate($request, ['file' => 'required|image']);

        $category->setBannerImage($request->file('file'));
    }
}
