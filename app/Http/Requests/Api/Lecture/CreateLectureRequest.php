<?php

namespace App\Http\Requests\Api\Lecture;

use Illuminate\Foundation\Http\FormRequest;

class CreateLectureRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d', 
            'type' => 'required|string|in:link,file',
            'video_url' => 'required_if:type,link|string|max:255',
            'file' => 'required_if:type,file|file|mimes:pdf,doc,docx,ppt,pptx|max:2048',
        ];
    }


    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must be less than 255 characters',
            'date.required' => 'Date is required',
            'date.date' => 'Date must be a valid date',
            'type.required' => 'Type is required',
            'type.string' => 'Type must be a string',
            'type.in' => 'Type must be either video or file',
            'video_url.required_if' => 'Video url is required if type is link',
            'video_url.string' => 'Video url must be a string',
            'video_url.max' => 'Video url must be less than 255 characters',
            'file.required_if' => 'File is required if type is file',
            'file.file' => 'File must be a file',
            'file.mimes' => 'File must be a file of type: pdf, doc, docx, ppt, pptx',
            'file.max' => 'File must be less than 2MB',
        ];
    }
}
