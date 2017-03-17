<?php

namespace App\Http\Controllers\Admin;

use App\Customers\Customer;
use App\Products\Product;
use App\Quotes\QuotesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuotesSearchController extends Controller
{

    /**
     * @var QuotesRepository
     */
    private $repo;

    public function __construct(QuotesRepository $quotesRepository)
    {
        $this->repo = $quotesRepository;
    }

    public function byCustomer(Customer $customer)
    {
        return $this->returnSearchViewWithResults($this->repo->forCustomer($customer), null, $customer);
    }

    public function byProduct(Product $product)
    {
        return $this->returnSearchViewWithResults($this->repo->byProduct($product), $product);
    }

    public function byCustomerWithProduct(Customer $customer, Product $product)
    {
        return $this->returnSearchViewWithResults($this->repo->forCustomerWithProduct($customer, $product), $product, $customer);
    }

    protected function returnSearchViewWithResults($quotes, $product = null, $customer = null)
    {
        return view('admin.quotes.search.results')->with(compact('quotes', 'product', 'customer'));
    }
}
