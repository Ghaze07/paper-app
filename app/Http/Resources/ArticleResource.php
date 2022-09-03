<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'type' => $this->type,
            'heading' => $this->heading,
            'header_image' => $this->header_image,
            'content' => $this->content,
            'media' => $this->media->map(function ($med) {
                return [
                    'id' => $med->id,
                    'file_path' => $med->file_path,
                ];
            })
        ];
    }
}
