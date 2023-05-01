<?php

namespace Altenic\MaybeCms\Http\Controllers;

use Altenic\MaybeCms\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    /**
     * @param string $postType
     * @param string $slug
     * @return Factory|View|Application
     */
    public function show(string $postType, string $slug): Factory|View|Application
    {
        return view('maybecms::post', [
            'post' => Post::query()->where('slug', $slug)->whereHas('postType', fn(Builder $query) => $query->where('slug', $postType))->firstOrFail(),
        ]);
    }
}
