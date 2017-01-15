<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSupplyForm extends FormRequest
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
            'quoted_date' => 'required|date',
            'supplier_id' => 'integer|exists:suppliers,id',
            'item_number' => 'required',
            'price' => 'required|integer',
            'package_price' => 'required|integer',
        ];
    }

    public function requiredFields()
    {
        return collect($this->only('quoted_date', 'supplier_id', 'item_number', 'price', 'package_price', 'remarks'))
            ->flatMap(function($value, $field) {
                return [$field => $value === '' ? null : $value];
            })->toArray();
    }
}
