<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFormRequest extends FormRequest
{
    protected $acceptedFields = ['name', 'product_code', 'description'];
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
            'name' => 'required|max:255',
            'product_code' => [
                'required',
                Rule::unique('products', 'product_code')->where(function($query) {
                    $query->whereNull('deleted_at');
                })
            ],
            'description' => ''
        ];
    }

    public function acceptedFields()
    {
        return $this->only($this->acceptedFields);
    }


}
