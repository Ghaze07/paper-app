<?php

namespace App\Http\Requests\Api\Paper;

use Illuminate\Foundation\Http\FormRequest;

class UploadPaperRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
            'question_paper' => 'required|file|mimes:pdf,png,jpg,jpeg|max:2048',
            'answer_type' => 'required|in:text,file',
            'answer_text' => 'required_if:answer_type,text',
            'answer_paper' => 'required_if:answer_type,file|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ];
    }


    public function messages()
    {
        return [
            'subject_id.required' => 'Subject id is required',
            'subject_id.exists' => 'this subject does not exists',
            'date.required' => 'Date is required',
            'date.date_format' => 'Date is invalid, must be in Y-m-d format',
            'question_paper.required' => 'Paper is required',
            'question_paper.file' => 'Paper must be a file',
            'question_paper.mimes' => 'Paper must be a file of type: pdf, png, jpg, jpeg',
            'question_paper.max' => 'Paper must be less than 2MB',
            'answer_type.required' => 'Answer type is required',
            'answer_type.in' => 'Answer type must be either text or file',
            'answer_text.required_if' => 'Answer text is required if answer type is text',
            'answer_paper.required_if' => 'Answer paper is required if answer type is file',
            'answer_paper.file' => 'Answer paper must be a file',
            'answer_paper.mimes' => 'Answer paper must be a file of type: pdf, png, jpg, jpeg',
            'answer_paper.max' => 'Answer paper must be less than 2MB',
        ];
    }
}
