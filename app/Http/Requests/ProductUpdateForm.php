<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateForm extends FormRequest
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
            'name' => 'required|max:255',
            'product_code' => 'required|unique:products,product_code,' . $this->product->id,
            'description' => '',
            'writeup' => '',
            'product_note' => ''
        ];
    }

    public function requiredFields()
    {
        return $this->only(['name', 'description', 'product_code', 'writeup']);
    }

    public function hasNote()
    {
        return isset($this->product_note) && ! empty($this->product_note);
    }
}
