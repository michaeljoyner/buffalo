<?php

namespace App\Http\Controllers;

use App\Products\ProductsRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductSearchResultsController extends Controller
{
    public function index(Request $request, ProductsRepository $productsRepository)
    {
        $query = $request->get('query', false);
        $products = $this->makePaginator($request, $productsRepository->searchAvailable($query));

        return view('front.search.index')->with(compact('query', 'products'));
    }

    protected function makePaginator($request, $items, $perPage = 18)
    {
        $page = $request->get('page', 1);
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(
            $items->slice($offset, $perPage)->all(),
            count($items),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
}
