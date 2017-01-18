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
        return [
            'name' => 'required',
            'email' => 'email',
            'website' => 'url'
        ];
    }

    public function acceptedFields()
    {
        return collect($this->only('name', 'phone', 'email', 'address', 'website', 'contact_person'))
            ->flatMap(function($value, $field) {
                return [$field => $value === '' ? null : $value];
            })->toArray();
    }
}
