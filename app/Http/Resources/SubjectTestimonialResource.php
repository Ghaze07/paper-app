<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectTestimonialResource extends JsonResource
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
            'testimonials' => $this->testimonials->map(function ($testimonial) {
                return [
                    'id' => $testimonial->id,
                    'question' => $testimonial->question,
                    'description' => $testimonial->description,
                    'options' => $testimonial->options,
                    'correct_option' => $testimonial->correct_option,
                ];
            }),
        ];
    }
}
