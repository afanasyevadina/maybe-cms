<?php

namespace Altenic\MaybeCms\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'active' => $this->active,
            'created_at' => Carbon::create($this->created_at)->toIso8601ZuluString(),
            'updated_at' => Carbon::create($this->updated_at)->toIso8601ZuluString(),
            'class_name' => 'page',
            'blocks' => BlockResource::collection($this->blocks),
            'meta' => MetaResource::make($this->meta),
        ];
    }
}
