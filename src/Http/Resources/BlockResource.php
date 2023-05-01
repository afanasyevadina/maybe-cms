<?php

namespace Altenic\MaybeCms\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $primitive = maybe_primitives()[$this->type] ?? [];
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'content' => collect($this->structure ?? [])->map(function($item) {
                $item['value'] = $this->content[$item['slug']]['value'] ?? '';
                $item['source'] = $this->content[$item['slug']]['source'] ?? null;
                $item['allow_source'] = (bool)@$item['allow_source'];
                $item['attachment'] = AttachmentResource::make($this->attachments()->where(['role' => $item['slug']])->first());
                return $item;
            })->toArray(),
            'query' => $this->query ?? [],
            'children' => $primitive['children'] ?? [],
            'allow_source' => (bool)@$primitive['allow_source'],
            'class_name' => 'block',
            'postType' => PostTypeResource::make($this->postType),
            'component' => $this->component,
            'active' => $this->active,
            'order' => $this->order,
            'blocks' => BlockResource::collection($this->blocks),
            'created_at' => Carbon::create($this->created_at)->toIso8601ZuluString(),
            'updated_at' => Carbon::create($this->updated_at)->toIso8601ZuluString(),
        ];
    }

    public static $wrap = null;
}
