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
            'buffalo_product_code' => 'max:255',
            'name' => 'max:255',
            'supplier_name' => 'max:255',
            'factory_number' => 'max:255',
            'remark' => '',
            'description' => '',
            'currency' => 'max:255',
            'exchange_rate' => 'numeric',
            'factory_price' => 'numeric',
            'package_price' => 'numeric',
            'additional_cost' => 'numeric',
            'additional_cost_memo' => 'max:255',
            'profit' => 'numeric',
            'moq' => 'numeric',
            'quantity' => 'numeric',
            'package_type' => 'max:255',
            'package_unit' => 'max:255',
            'package_inner' => 'numeric',
            'package_outer' => 'numeric',
            'package_carton' => 'max:255',
            'net_weight' => 'numeric',
            'gross_weight' => 'numeric'
        ];
    }

    public function fieldsToUpdate()
    {
        return collect($this->only([
            'buffalo_product_code',
            'name',
            'supplier_name',
            'factory_number',
            'remark',
            'description',
            'currency',
            'exchange_rate',
            'factory_price',
            'package_price',
            'additional_cost',
            'additional_cost_memo',
            'profit',
            'moq',
            'quantity',
            'package_type',
            'package_unit',
            'package_inner',
            'package_outer',
            'package_carton',
            'net_weight',
            'gross_weight'
        ]))->filter(function($value) {
            return ! is_null($value);
        })->toArray();
    }
}
