<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\PresetApplyRequest;
use Altenic\MaybeCms\Http\Requests\PresetCreateRequest;
use Altenic\MaybeCms\Http\Requests\PresetUpdateRequest;
use Altenic\MaybeCms\Http\Resources\BlockResource;
use Altenic\MaybeCms\Http\Resources\PresetResource;
use Altenic\MaybeCms\Models\Preset;

class PresetController extends Controller
{
    public function index()
    {
        return PresetResource::collection(Preset::all());
    }

    public function show(Preset $preset)
    {
        return PresetResource::make($preset);
    }

    public function store(PresetCreateRequest $request)
    {
        $preset = Preset::create($request->validated());
        return response()->json([
            'id' => $preset->id,
        ], 201);
    }

    public function update(Preset $preset, PresetUpdateRequest $request)
    {
        $preset->update($request->safe()->except(['blocks']));
        $preset->updateBlocks($request->input('blocks') ?? []);
        return response()->noContent(200);
    }

    public function apply(Preset $preset, PresetApplyRequest $request)
    {
        $className = $request->input('attachable_type');
        $attachable = $className::find($request->input('attachable_id'));
        return BlockResource::collection($attachable->appendBlocks($preset->blocks));
    }

    public function destroy(Preset $preset)
    {
        $preset->delete();
        return response()->noContent();
    }
}
