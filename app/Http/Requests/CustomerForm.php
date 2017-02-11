<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerForm extends FormRequest
{

    protected $fieldlist = [
        'name',
        'contact_person',
        'email',
        'phone',
        'fax',
        'website',
        'address',
        'remarks',
        'payment_terms'
    ];

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
            'name'           => 'required|max:255',
            'contact_person' => 'required|max:255',
            'email'          => 'required|email|max:255'
        ];
    }

    public function requiredFields()
    {
        return collect($this->only($this->fieldlist))
            ->flatMap(function ($value, $field) {
                return [$field => $value === '' ? null : $value];
            })->toArray();
    }
}
