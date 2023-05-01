<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\BlockCreateRequest;
use Altenic\MaybeCms\Http\Resources\BlockResource;
use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\PostType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlockController extends Controller
{
    /**
     * @param Block $block
     * @return BlockResource
     */
    public function show(Block $block): BlockResource
    {
        return BlockResource::make($block);
    }
    /**
     * @param BlockCreateRequest $request
     * @return JsonResponse
     */
    public function store(BlockCreateRequest $request): JsonResponse
    {
        $block = Block::query()->create($request->validated());
        return BlockResource::make($block)->toResponse($request)->setStatusCode(201);
    }

    /**
     * @param Block $block
     * @return Response
     */
    public function destroy(Block $block): Response
    {
        $block->delete();
        return response()->noContent();
    }

    /**
     * @param Block $block
     * @return Response
     */
    public function clone(Block $block): Response
    {
        $block->attachable->appendBlocks([$block]);
        return response()->noContent(201);
    }

    /**
     * @param Block $block
     * @param PostType $postType
     * @param Request $request
     * @return Response
     */
    public function setPostType(Block $block, PostType $postType, Request $request): Response
    {
        $block->setPostType($postType->id);
        $block->update(['query' => $request->input('query')]);
        return response()->noContent();
    }

    /**
     * @param Block $block
     * @return Response
     */
    public function unsetPostType(Block $block): Response
    {
        $block->setPostType(null);
        $block->update(['query' => []]);
        return response()->noContent();
    }
}
