<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteItemUpdate extends FormRequest
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
            'name' => 'max:255',
            'buffalo_product_code' => 'max:255',
            'supplier_name' => 'max:255',
            'factory_number' => 'max:255',
            'factory_price' => 'numeric',
            'additional_cost' => 'numeric',
            'exchange_rate' => 'numeric',
            'quantity' => 'numeric',
        ];
    }

    public function fieldsToUpdate()
    {
        return collect($this->only([
            'name',
            'buffalo_product_code',
            'supplier_name',
            'factory_number',
            'factory_price',
            'additional_cost',
            'exchange_rate',
            'quantity',
            'description',
            'currency'
        ]))->filter(function($value) {
            return ! is_null($value);
        })->toArray();
    }
}
