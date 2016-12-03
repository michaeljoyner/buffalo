<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Products\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryOrderController extends Controller
{

    public function show()
    {
        $categories = Category::getOrdered();
        return view('admin.categories.sort')->with(compact('categories'));
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'order' => 'required|array',
            'order.*' => 'integer|exists:categories,id'
        ]);

        Category::setOrder($request->order);

        return response()->json('ok');
    }
}
