<?php

namespace App\Http\Requests\Api\Lecture;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLectureRequest extends FormRequest
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
            'course_id' => 'required|integer|exists:courses,id',
            'title' => 'sometimes|string|max:255',
            'date' => 'sometimes|date_format:Y-m-d',
            'type' => 'required|string|in:link,file,other',
            'video_url' => 'sometimes|required_if:type,link|string|max:255',
            'file' => 'sometimes|required_if:type,file|file|mimes:pdf,doc,docx,ppt,pptx|max:2048',
        ];
    }


    public function messages()
    {
        return [
            'course_id.required' => 'Course id is required',
            'course_id.integer' => 'Course id must be an integer',
            'course_id.exists' => 'Course id must exist in the database',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must be less than 255 characters',
            'date.date' => 'Date must be a valid date',
            'type.required' => 'Type is required',
            'type.string' => 'Type must be a string',
            'type.in' => 'Type must be either video or file or other',
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
