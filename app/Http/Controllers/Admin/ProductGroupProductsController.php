<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Http\Requests\ProductFormRequest;
use App\Products\ProductGroup;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductGroupProductsController extends Controller
{

    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function store(ProductFormRequest $request, ProductGroup $productGroup)
    {
        $product = $productGroup->addProduct($request->acceptedFields());

        $this->flasher->success('Product Added', $product->name . ' has been added to ' . $productGroup->name);

        return redirect('admin/products/' . $product->id);
    }
}
