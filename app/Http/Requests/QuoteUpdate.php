<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteUpdate extends FormRequest
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
            'valid_until' => 'date'
        ];
    }

    public function requiredFields()
    {
        return collect($this->only('valid_until', 'payment_terms', 'remarks'))
            ->flatMap(function($value, $field) {
                return [$field => $value === '' ? null : $value];
            })->toArray();
    }
}
