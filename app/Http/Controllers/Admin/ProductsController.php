<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Products\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{

    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function show(Product $product)
    {
        return view('admin.products.show')->with(compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit')->with(compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'product_code' => 'required|unique:products,product_code,'.$product->id,
            'description' => '',
            'writeup' => ''
        ]);

        $product->update($request->only(['name', 'description', 'product_code', 'writeup']));

        $this->flasher->success('Updated.', 'Your changes have been saved.');

        return redirect('admin/products/' . $product->id);
    }

    public function delete(Request $request, Product $product)
    {
        $product->delete();

        $this->flasher->success('Deleted', 'The product has been removed from the catelog');

        return redirect('admin/categories/' . $product->category->id);
    }
}
