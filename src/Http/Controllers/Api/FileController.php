<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\FileCreateRequest;
use Altenic\MaybeCms\Http\Resources\FileResource;
use Altenic\MaybeCms\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FileController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return FileResource::collection(File::query()->where('type', $request->input('type'))->latest()->paginate(50));
    }

    /**
     * @param FileCreateRequest $request
     * @return JsonResponse
     */
    public function store(FileCreateRequest $request): JsonResponse
    {
        $file = File::query()->create($request->safe()->except('file'));
        return FileResource::make($file)->toResponse($request)->setStatusCode(201);
    }

    /**
     * @param File $file
     * @return FileResource
     */
    public function show(File $file): FileResource
    {
        return FileResource::make($file);
    }

    /**
     * @param File $file
     * @return Response
     */
    public function destroy(File $file): Response
    {
        $file->delete();
        return response()->noContent();
    }
}
