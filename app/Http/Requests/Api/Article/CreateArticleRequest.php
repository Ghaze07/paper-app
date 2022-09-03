<?php

namespace App\Http\Requests\Api\Article;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            'type' => 'required|in:news,blog,article',
            'heading' => 'required|string|max:255',
            'header_image' => 'sometimes|file|mimes:pdf,png,jpg,jpeg|max:2048',
            'content' => 'required',
            'media' => 'sometimes|array'
        ];
    }

    
    public function messages()
    {
        return [
            'type.required' => 'type is required',
            'type.in' => 'type must be news, blog or article',
            'heading.required' => 'a heading is required',
            'heading.string' => 'a heading must be a string',
            'header_image.file' => 'a header image must be file',
            'content.required' => 'a content is required',
            'media.array' => 'a media must be an array of files',
        ];
    }

}
