<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\PostCreateRequest;
use Altenic\MaybeCms\Http\Requests\PostUpdateRequest;
use Altenic\MaybeCms\Http\Resources\PostListResource;
use Altenic\MaybeCms\Http\Resources\PostResource;
use Altenic\MaybeCms\Models\PostType;
use Altenic\MaybeCms\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * @param string $postType
     * @return AnonymousResourceCollection
     */
    public function index(string $postType): AnonymousResourceCollection
    {
        $model = PostType::query()->where('slug', $postType)->firstOrFail();
        return PostListResource::collection(Post::byType($model->id)->paginate(20));
    }

    /**
     * @param string $postType
     * @param Post $post
     * @return PostResource
     */
    public function show(string $postType, Post $post): PostResource
    {
        return PostResource::make($post);
    }

    /**
     * @param $postType
     * @param PostCreateRequest $request
     * @return JsonResponse
     */
    public function store($postType, PostCreateRequest $request): JsonResponse
    {
        $model = PostType::query()->where('slug', $postType)->firstOrFail();
        $post = $model->posts()->create($request->validated());
        return response()->json([
            'id' => $post->id,
        ], 201);
    }

    /**
     * @param string $postType
     * @param Post $post
     * @param PostUpdateRequest $request
     * @return Response
     */
    public function update(string $postType, Post $post, PostUpdateRequest $request): Response
    {
        $post->updateContent($request->safe()->except(['blocks', 'meta', 'relations']));
        $post->updateBlocks($request->input('blocks') ?? []);
        foreach ($request->input('relations') as $relation) {
            $modelRelation = $post->relations()->find($relation['id']);
            $relatedPosts = $modelRelation?->type == 'many-to-one' ? [$relation['related_post']] : ($relation['related_posts'] ?? []);
            $post->posts()->wherePivot('relation_id', $modelRelation?->id)->whereNotIn('related_post_id', $relatedPosts)->detach();
            $post->posts()->attach(array_filter($relatedPosts), [
                'relation_id' => $modelRelation?->id,
            ]);
        }
        return response()->noContent(200);
    }

    /**
     * @param string $postType
     * @param Post $post
     * @return Response
     */
    public function destroy(string $postType, Post $post): Response
    {
        $post->delete();
        return response()->noContent();
    }
}
