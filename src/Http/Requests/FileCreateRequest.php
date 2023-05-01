<?php

namespace Altenic\MaybeCms\Http\Requests;

class FileCreateRequest extends JsonRequest
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
            'type' => 'required|in:image,video,file',
            'file' => 'required|file' . ($this->input('type') == 'image' ? '|image' : '') . ($this->input('type') == 'video' ? '|mimetypes:video/*' : ''),
        ];
        return $rules;
    }
}
