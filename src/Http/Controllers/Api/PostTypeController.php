<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\PostTypeCreateRequest;
use Altenic\MaybeCms\Http\Requests\PostTypeUpdateRequest;
use Altenic\MaybeCms\Http\Resources\PostTypeResource;
use Altenic\MaybeCms\Models\PostType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PostTypeController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return PostTypeResource::collection(PostType::all());
    }

    /**
     * @param PostType $postType
     * @return PostTypeResource
     */
    public function show(PostType $postType): PostTypeResource
    {
        return PostTypeResource::make($postType);
    }

    /**
     * @param PostTypeCreateRequest $request
     * @return JsonResponse
     */
    public function store(PostTypeCreateRequest $request): JsonResponse
    {
        $model = PostType::create($request->validated());
        return response()->json([
            'id' => $model->id,
        ], 201);
    }

    /**
     * @param PostType $postType
     * @param PostTypeUpdateRequest $request
     * @return Response
     */
    public function update(PostType $postType, PostTypeUpdateRequest $request): Response
    {
        $postType->update($request->safe()->except('relations'));
        $relations = collect($request->input('relations') ?? [])->map(function ($item) use($postType) {
            $item = collect($item)->only(['id', 'title', 'type', 'related_post_type_id'])->toArray();
            if (isset($item['id'])) {
                $relation = $postType->relations()->findOrFail($item['id']);
                $relation->update($item);
            } else $relation = $postType->relations()->create($item);
            return $relation->id;
        });
        $postType->relations()->whereNotIn('id', $relations)->delete();
        return response()->noContent(200);
    }

    /**
     * @param PostType $postType
     * @return Response
     */
    public function destroy(PostType $postType): Response
    {
        $postType->delete();
        return response()->noContent();
    }
}
