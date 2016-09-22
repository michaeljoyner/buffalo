<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Products\Category;
use App\Products\Subcategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubcategoriesController extends Controller
{

    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function show(Subcategory $subcategory)
    {
        $subcategory->load(['category', 'productGroups', 'products']);
        $products = $subcategory->products()->paginate(18);
        return view('admin.subcategories.show')->with(compact('subcategory', 'products'));
    }

    public function store(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => ''
        ]);

        $subcategory = $category->addSubcategory($request->only(['name', 'description']));

        $this->flasher->success('Success', $request->name . ' has been added to ' . $category->name);

        return redirect('admin/subcategories/' . $subcategory->id);
    }

    public function edit(Subcategory $subcategory)
    {
        return view('admin.subcategories.edit')->with(compact('subcategory'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => ''
        ]);

        $subcategory->update($request->only(['name', 'description']));

        $this->flasher->success('Success', 'Your changes have been saved.');

        return redirect('admin/subcategories/'.$subcategory->id);
    }

    public function delete(Subcategory $subcategory)
    {
        $subcategory->delete();

        $this->flasher->success('Success', 'The subcategory gas been deleted');

        return redirect('admin/categories/' . $subcategory->category->id);
    }
}
