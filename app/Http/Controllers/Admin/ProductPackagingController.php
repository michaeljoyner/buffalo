<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Http\Requests\ProductPackagingForm;
use App\Products\Packaging;
use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductPackagingController extends Controller
{

    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function store(ProductPackagingForm $request, Product $product)
    {
        $product->addPackaging($request->requiredFields());

        $this->flasher->success('Success', 'The packaging info has been saved for the product');

        return redirect('admin/products/' . $product->id);
    }

    public function update(ProductPackagingForm $request, Packaging $packaging)
    {
        $packaging->update($request->requiredFields());

        $this->flasher->success('Success', 'Your changes have been saved');

        return redirect('admin/products/' . $packaging->product->id);
    }

    public function delete(Packaging $packaging)
    {
        $packaging->delete();

        $this->flasher->success('Success', 'The packaging has been deleted');

        return redirect('admin/products/' . $packaging->product->id);
    }
}
