<?php

namespace App\Http\Controllers\Admin;

use App\Products\ProductsRepository;
use App\ProductStats\ProductStatsFactory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductsSearchController extends Controller
{

    public function show()
    {
        $stats = ProductStatsFactory::make();
        return view('admin.products.search.index')->with(compact('stats'));
    }

    public function search(Request $request, ProductsRepository $repository)
    {
        $this->validate($request, ['searchterm' => 'required']);

        return $repository->search($request->searchterm)->unique('id');
    }
}
