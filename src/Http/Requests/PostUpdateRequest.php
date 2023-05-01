<?php

namespace Altenic\MaybeCms\Http\Requests;

use Illuminate\Support\Str;

class PostUpdateRequest extends JsonRequest
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
            'slug' => 'required',
            'description' => 'sometimes|present',
            'content' => 'sometimes|array',
            'blocks' => 'sometimes|array',
            'blocks.*.id' => 'required',
            'blocks.*.blocks' => 'sometimes|array',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug')),
        ]);
    }
}
