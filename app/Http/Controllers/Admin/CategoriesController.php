<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Products\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.categories.index')->with(compact('categories'));
    }

    public function show(Category $category)
    {
        $category->load(['subcategories.productGroups']);
        $products = $category->products()->orderBy('new_until', 'desc')->latest()->paginate(18);
        return view('admin.categories.show')->with(compact('category', 'products'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => ''
        ]);

        $category = Category::create($request->only(['name', 'description']));

        $this->flasher->success('Category Added', 'The category has been added');

        return redirect('admin/categories/' . $category->id);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit')->with(compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => ''
        ]);

        $category->update($request->only(['name', 'description']));

        $this->flasher->success('Category Updated', 'The category details have been updated');

        return redirect('admin/categories/' . $category->id);
    }

    public function delete(Category $category)
    {
        $category->delete();

        $this->flasher->success('Category Deleted', 'The category has been deleted');

        return redirect('admin/categories');
    }
}
