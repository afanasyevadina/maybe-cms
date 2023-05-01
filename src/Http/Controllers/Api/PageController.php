<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\PageCreateRequest;
use Altenic\MaybeCms\Http\Requests\PageUpdateRequest;
use Altenic\MaybeCms\Http\Resources\PageListResource;
use Altenic\MaybeCms\Http\Resources\PageResource;
use Altenic\MaybeCms\Models\File;
use Altenic\MaybeCms\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PageController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return PageListResource::collection(Page::query()->paginate(20));
    }

    /**
     * @param Page $page
     * @return PageResource
     */
    public function show(Page $page): PageResource
    {
        return PageResource::make($page);
    }

    /**
     * @param PageCreateRequest $request
     * @return JsonResponse
     */
    public function store(PageCreateRequest $request): JsonResponse
    {
        $page = Page::query()->create($request->validated());
        return response()->json([
            'id' => $page->id,
        ], 201);
    }

    /**
     * @param Page $page
     * @param PageUpdateRequest $request
     * @return Response
     */
    public function update(Page $page, PageUpdateRequest $request): Response
    {
        $page->update($request->safe()->except(['blocks', 'meta']));
        $meta = $page->meta()->updateOrCreate([], collect($request->input('meta'))->only(['title', 'description'])->toArray());
        if ($request->input('meta.attachment.file.id')) {
            $meta->attachment()->updateOrCreate([], ['file_id' => File::query()->findOrFail($request->input('meta.attachment.file.id'))->id]);
        } else {
            $meta->attachment()->delete();
        }
        $page->updateBlocks($request->input('blocks') ?? []);
        return response()->noContent(200);
    }

    /**
     * @param Page $page
     * @return Response
     */
    public function destroy(Page $page): Response
    {
        $page->delete();
        return response()->noContent();
    }
}
