<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Http\Requests\ProductFormRequest;
use App\Products\Subcategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubcategoryProductsController extends Controller
{
    /**
     * @var Flasher
     */
    private $flasher;

    /**
     * SubcategoryProductsController constructor.
     * @param Flasher $flasher
     */
    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function store(ProductFormRequest $request, Subcategory $subcategory)
    {
        $product = $subcategory->addProduct($request->acceptedFields());

        $this->flasher->success('Product Added', $product->name . ' has been added to ' . $subcategory->name);

        return redirect('admin/products/' . $product->id . '/edit');
    }
}
