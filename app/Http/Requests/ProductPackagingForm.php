<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductPackagingForm extends FormRequest
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
            'type' => 'required|max:255',
            'unit' => 'required|max:255',
            'inner' => 'numeric',
            'outer' => 'numeric',
            'net_weight' => 'numeric',
            'gross_weight' => 'numeric'
        ];
    }

    public function requiredFields()
    {
        return $this->only([
            'type',
            'unit',
            'inner',
            'outer',
            'carton',
            'net_weight',
            'gross_weight'
        ]);
    }
}
