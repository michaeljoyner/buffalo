<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierForm extends FormRequest
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
        if($this->route('supplier')) {
            return [
                'name' => [
                    'required',
                    Rule::unique('suppliers')->ignore($this->route('supplier')->id),
                ]
            ];
        }

        return ['name' => 'required|unique:suppliers'];

    }

    public function acceptedFields()
    {
        return collect($this->only('name', 'phone', 'email', 'address'))->flatMap(function($value, $field) {
            return [$field => $value === '' ? null : $value];
        })->toArray();
    }
}
