<?php

namespace App\Http\Requests\Api\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'subject_id' => 'sometimes|integer|exists:subjects,id',
        ];
    }


    public function messages()
    {
        return [
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must be less than 255 characters',
            'description.string' => 'Description must be a string',
            'description.max' => 'Description must be less than 255 characters',
            'subject_id.integer' => 'Subject id must be an integer',
            'subject_id.exists' => 'Subject id must be an existing subject',
        ];
    }
}
