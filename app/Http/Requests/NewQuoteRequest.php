<?php

namespace App\Http\Requests;

use App\Customers\Customer;
use App\Orders\Order;
use App\Quotes\Quote;
use Illuminate\Foundation\Http\FormRequest;

class NewQuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'order_id' => 'required_without:customer|exists:orders,id'
        ];
    }

    public function makeQuote($customer = null)
    {
        $order = $this->order_id ? Order::findOrFail($this->order_id) : null;

        if(! $order && ! $customer) {
            throw new \Exception('Must have order id if no customer given');
        }

        if(! $customer) {
            $customer = Customer::createFromOrder($order);
        }

        return $customer->newQuote($order);
    }
}
