<?php

namespace Altenic\MaybeCms\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RelationResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->title,
            'type' => $this->type,
            'related_post_type_id' => $this->related_post_type_id,
            'post_type' => [
                'id' => $this->postType->id,
                'slug' => $this->postType->slug,
                'title' => $this->postType->title,
                'structure' => [
                    'fields' => $this->postType->structure['fields'] ?? [],
                ],
            ],
            'related_post_type' => [
                'id' => $this->relatedPostType->id,
                'slug' => $this->relatedPostType->slug,
                'title' => $this->relatedPostType->title,
                'structure' => [
                    'fields' => $this->relatedPostType->structure['fields'] ?? [],
                ],
            ],
        ];
    }
}
