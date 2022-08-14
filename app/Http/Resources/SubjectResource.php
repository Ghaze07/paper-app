<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'papers' => $this->papers->map(function($paper) {
                return [
                    'id' => $paper->id,
                    'question_paper_url' => $paper->question_file_path,
                    'answer_type' => $paper->answer_type,
                    'answer_paper_url' => $paper->answer_file_path,
                    'answer_text' => $paper->answer_text,
                    'date' => $paper->date,
                ];
            }),
        ];
    }
}
