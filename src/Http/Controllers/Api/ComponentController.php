<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\ComponentApplyRequest;
use Altenic\MaybeCms\Http\Requests\ComponentCreateRequest;
use Altenic\MaybeCms\Http\Requests\ComponentUpdateRequest;
use Altenic\MaybeCms\Http\Resources\BlockResource;
use Altenic\MaybeCms\Http\Resources\ComponentResource;
use Altenic\MaybeCms\Models\Component;

class ComponentController extends Controller
{
    public function index()
    {
        return ComponentResource::collection(Component::all());
    }

    public function show(Component $component)
    {
        return ComponentResource::make($component);
    }

    public function store(ComponentCreateRequest $request)
    {
        $component = Component::create($request->validated());
        return response()->json([
            'id' => $component->id,
        ], 201);
    }

    public function update(Component $component, ComponentUpdateRequest $request)
    {
        $component->update($request->safe()->except(['blocks']));
        $component->updateBlocks($request->input('blocks') ?? []);
        return response()->noContent(200);
    }

    public function apply(Component $component, ComponentApplyRequest $request)
    {
        $className = $request->input('attachable_type');
        $attachable = $className::find($request->input('attachable_id'));
        return BlockResource::make($attachable->blocks()->create([
            'type' => 'component',
            'title' => $component->title,
            'component_id' => $component->id,
        ]));
    }

    public function destroy(Component $component)
    {
        $component->delete();
        return response()->noContent();
    }
}
