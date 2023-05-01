<?php

namespace Altenic\MaybeCms\Http\Requests;

use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\Meta;

class AttachmentCreateRequest extends JsonRequest
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
        $rules = [
            'attachable_id' => 'required',
            'attachable_type' => 'required|in:' . implode(',', [Block::class, Meta::class]),
            'type' => 'required|in:image,video,file',
            'file' => 'required|file' . ($this->input('type') == 'image' ? '|image' : '') . ($this->input('type') == 'video' ? '|mimetypes:video/*' : ''),
        ];
        if($this->input('type') == 'image') $rules['alt'] = 'sometimes';
        return $rules;
    }
}
