<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Products\ProductGroup;
use App\Products\Subcategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductGroupsController extends Controller
{

    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function show(ProductGroup $productGroup)
    {
        $productGroup->load(['subcategory', 'products']);
        $products = $productGroup->products()->paginate(18);

        return view('admin.productgroups.show')->with(compact('productGroup', 'products'));
    }

    public function store(Request $request, Subcategory $subcategory)
    {
        $this->validate($request, ['name' => 'required|max:255']);

        $productGroup = $subcategory->addProductGroup($request->only(['name', 'description']));

        $this->flasher->success('Product Group Added.', $productGroup->name . ' has been added to ' . $subcategory->name);

        return redirect('admin/productgroups/' . $productGroup->id);
    }

    public function edit(ProductGroup $productGroup)
    {
        return view('admin.productgroups.edit')->with(compact('productGroup'));
    }

    public function update(Request $request, ProductGroup $productGroup)
    {
        $this->validate($request, ['name' => 'required|max:255']);

        $productGroup->update($request->only(['name', 'description']));

        $this->flasher->success('Success', 'Your changes have been successfully saved');

        return redirect('admin/productgroups/' . $productGroup->id);
    }

    public function delete(ProductGroup $productGroup)
    {
        $productGroup->delete();

        $this->flasher->success('Deleted', 'The product group has been removed');

        return redirect('admin/subcategories/' . $productGroup->subcategory->id);
    }
}
