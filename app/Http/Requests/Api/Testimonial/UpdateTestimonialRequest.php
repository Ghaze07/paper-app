<?php

namespace App\Http\Requests\Api\Testimonial;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
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
            'subject_id' => 'required|exists:subjects,id',
            'question' => 'sometimes|string|max:255',
            'options' => 'sometimes|array',
            'options.*' => 'required_if:options,exists|string|max:255',
            'correct_option' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'subject_id.required' => 'Subject id is required',
            'subject_id.exists' => 'this subject does not exists',
            'question.max' => 'Question may not be greater than 255 characters.',
            'options.array' => 'Options must be an array',
            'correct_option.max' => 'Correct option may not be greater than 255 characters.',
            'description.max' => 'Description may not be greater than 255 characters.',
        ];
    }
}
