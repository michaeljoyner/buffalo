<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Http\Requests\ProductFormRequest;
use App\Products\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryProductsController extends Controller
{
    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function store(ProductFormRequest $request, Category $category)
    {
        $product = $category->addProduct($request->acceptedFields());

        $this->flasher->success('Product Added', $product->name . ' has been added to ' . $category->name);

        return redirect('admin/products/' . $product->id . '/edit');
    }
}
