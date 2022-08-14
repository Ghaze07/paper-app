<?php

namespace App\Http\Requests\Api\Testimonial;

use Illuminate\Foundation\Http\FormRequest;

class CreateTestimonialRequest extends FormRequest
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
            'mcqs' => 'required|array',
            'mcqs.*.question' => 'required|string|max:255',
            'mcqs.*.description' => 'sometimes|string|max:255',
            'mcqs.*.options' => 'required|array',
            'mcqs.*.correct_option' => 'required|string|max:255',
        ];
    }


    public function messages()
    {
        return [
            'subject_id.required' => 'Subject id is required',
            'subject_id.exists' => 'this subject does not exists',
            'mcqs.required' => 'Mcqs is required',
            'mcqs.array' => 'Mcqs must be an array',
            'mcqs.*.question.required' => 'Question is required',
            'mcqs.*.question.max' => 'Question may not be greater than 255 characters.',
            'mcqs.*.description.max' => 'Description may not be greater than 255 characters.',
            'mcqs.*.options.required' => 'Options is required',
            'mcqs.*.options.array' => 'Options must be an array',
            'mcqs.*.correct_option.required' => 'Correct option is required',
            'mcqs.*.correct_option.max' => 'Correct option may not be greater than 255 characters.',
        ];
    }
}
