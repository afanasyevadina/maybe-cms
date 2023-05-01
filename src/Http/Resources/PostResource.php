<?php

namespace Altenic\MaybeCms\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'description' => $this->description,
            'content' => collect($this->postType->structure['fields'] ?? [])->map(function($item) {
                $item['value'] = $this->content[$item['slug']]['value'] ?? '';
                $item['attachment'] = AttachmentResource::make($this->attachments()->where(['role' => $item['slug']])->first());
                return $item;
            })->toArray(),
            'active' => $this->active,
            'created_at' => Carbon::create($this->created_at)->toIso8601ZuluString(),
            'updated_at' => Carbon::create($this->updated_at)->toIso8601ZuluString(),
            'class_name' => 'post',
            'blocks' => BlockResource::collection($this->blocks),
            'relations' => $this->relations->map(function ($relation) {
                $posts = $this->posts()->wherePivot('relation_id', $relation->id)->pluck('related_post_id');
                return array_merge(RelationResource::make($relation)->toArray(request()), $relation->type == 'many-to-one' ? [
                    'related_post' => $posts->first(),
                ] : [
                    'related_posts' => $posts,
                ]);
            }),
            'inverse_relations' => $this->inverseRelations->map(function ($relation) {
                $posts = $this->inversePosts()->wherePivot('relation_id', $relation->id)->get();
                return array_merge(RelationResource::make($relation)->toArray(request()), [
                    'related_posts' => PostListResource::collection($posts),
                ]);
            }),
            'meta' => MetaResource::make($this->meta),
        ];
    }
}
