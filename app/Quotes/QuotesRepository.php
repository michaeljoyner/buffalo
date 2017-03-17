<?php


namespace App\Quotes;


class QuotesRepository
{

    public function forCustomer($customer, $paginateLength = 15)
    {
        return $customer->quotes()->paginate($paginateLength);
    }

    public function byProduct($product, $paginateLength = 15)
    {
        return $this->fetchQuotesHavingProduct(Quote::latest(), $product, $paginateLength);
    }

    public function forCustomerWithProduct($customer, $product, $paginateLength = 15)
    {
        return $this->fetchQuotesHavingProduct($customer->quotes(), $product, $paginateLength);
    }

    private function fetchQuotesHavingProduct($quotes, $product, $paginateLength)
    {
        return $quotes->whereHas('items', function($query) use ($product) {
            $query->where('product_id', $product->id);
        })->paginate($paginateLength);
    }
}