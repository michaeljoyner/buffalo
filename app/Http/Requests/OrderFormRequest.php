<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderFormRequest extends FormRequest
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
            'company'        => 'required|max:255',
            'contact_person' => 'required|max:255',
            'phone'          => 'max:255',
            'fax'            => 'max:255',
            'email'          => 'required|email|max:255',
            'website'        => 'max:255',
            'referrer'       => 'max:255',
            'requirements'   => ''
        ];
    }

    public function acceptedFields()
    {
        return $this->only(['company', 'contact_person', 'phone', 'fax', 'email', 'website', 'referrer', 'other_referrer', 'requirements']);
    }
}
