<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectCourseResource extends JsonResource
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
            'courses' => $this->courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'lectures' => $course->lectures->map(function ($lecture) {
                        return [
                            'id' => $lecture->id,
                            'title' => $lecture->title,
                            'date' => $lecture->date,
                            'type' => $lecture->type,
                            'video_url' => $lecture->video_url,
                            'file_path' => $lecture->file_path,
                        ];
                    }),
                ];
            }),
        ];
    }
}
