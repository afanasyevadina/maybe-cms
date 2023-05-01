<?php

namespace Altenic\MaybeCms\Http\Requests;

class SettingsUpdateRequest extends JsonRequest
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
            'settings' => 'sometimes|array',
            'settings.*.slug' => 'required|exists:settings,slug',
            'settings.*.value' => 'present',
        ];
    }
}
