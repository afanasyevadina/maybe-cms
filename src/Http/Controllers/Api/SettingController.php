<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\SettingsUpdateRequest;
use Altenic\MaybeCms\Http\Resources\SettingsResource;
use Altenic\MaybeCms\Models\Setting;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SettingController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return SettingsResource::collection(Setting::all());
    }

    /**
     * @param SettingsUpdateRequest $request
     * @return Response
     */
    public function update(SettingsUpdateRequest $request): Response
    {
        collect($request->input('settings'))->each(fn($setting) => Setting::query()->where('slug', $setting['slug'])->first()?->update(['value' => $setting['value']]));
        return response()->noContent(200);
    }
}
