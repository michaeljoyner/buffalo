<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Http\Requests\ProductSupplyForm;
use App\Products\Product;
use App\Sourcing\Supply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuppliesController extends Controller
{

    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function index(Request $request, Product $product)
    {
        $byDateOnly = ! $request->has('factories');
        $product->load('supplies');
        return view('admin.products.supplies.index')->with(compact('product', 'byDateOnly'));
    }

    public function store(ProductSupplyForm $request, Product $product)
    {
        $supply = $product->addSupply($request->requiredFields());

        $this->flasher->success('Supply Created', 'The supply has been saved for this product');

        return redirect('admin/products/' . $product->id . '/supplies');
    }

    public function delete(Supply $supply)
    {
        $supply->delete();

        $this->flasher->success('Supply Deleted', 'The supply has been removed from this product');

        return redirect('admin/products/' . $supply->product->id . '/supplies');
    }
}
