<?php

namespace App\Http\Requests\Api\Subject;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubjectsRequest extends FormRequest
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
            'subjects' => 'required|array',
            'subjects.*.title' => 'required|string|max:255',
            'subjects.*.description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'subjects.required' => 'The subjects field is required.',
            'subject.array' => 'The subjects field must be an array.',
            'subjects.*.title.required' => 'The title field is required.',
            'subjects.*.title.max' => 'The title may not be greater than 255 characters.',
            'subjects.*.description.string' => 'The description must be a string.',
        ];
    }
}
