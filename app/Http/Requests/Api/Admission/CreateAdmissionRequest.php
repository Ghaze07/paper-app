<?php

namespace App\Http\Requests\Api\Admission;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdmissionRequest extends FormRequest
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
            'dob' => 'required|date_format:Y-m-d',
            'last_degree' => 'required|string|max:255',
            'css_attempted' => 'required|boolean'
        ];
    }


    public function messages()
    {
        return [
            'dob.required' => 'date of birth is required',
            'dob.date_format' => 'date must be in YYYY-MM-DD format',
            'last_degree.required' => 'last degree is required',
            'css_attempted.required' => 'css attempt is required',
            'css_attempted.boolean' => 'css attempt must be true or false',
        ];
    }
}
