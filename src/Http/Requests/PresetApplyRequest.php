<?php

namespace Altenic\MaybeCms\Http\Requests;

use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\Component;
use Altenic\MaybeCms\Models\Page;
use Altenic\MaybeCms\Models\Post;
use Altenic\MaybeCms\Models\Preset;

class PresetApplyRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('admin');
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'attachable_type' => maybe_attachable_class($this->input('attachable_type')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $className = $this->input('attachable_type') ?? Block::class;
        return [
            'attachable_type' => 'required|in:' . implode(',', [Page::class, Post::class, Preset::class, Component::class, Block::class]),
            'attachable_id' => 'required|exists:' .(new $className)->getTable() . ',id',
        ];
    }
}
