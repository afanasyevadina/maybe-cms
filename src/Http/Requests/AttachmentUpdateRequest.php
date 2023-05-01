<?php

namespace Altenic\MaybeCms\Http\Requests;

class AttachmentUpdateRequest extends JsonRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'file' => 'sometimes|file' . ($this->route('attachment')->type == 'image' ? '|image' : '') . ($this->route('attachment')->type == 'video' ? '|mimetypes:video/*' : ''),
        ];
        if ($this->route('attachment')->type == 'image') $rules['alt'] = 'sometimes';
        return $rules;
    }
}
