<?php

namespace Altenic\MaybeCms\Http\Requests;

class ComponentUpdateRequest extends JsonRequest
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
        return [
            'title' => 'required',
            'blocks' => 'sometimes|array',
            'blocks.*.id' => 'required',
            'blocks.*.attachment' => 'sometimes|array|nullable',
            'blocks.*.blocks' => 'sometimes|array',
        ];
    }
}
