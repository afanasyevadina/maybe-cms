<?php

namespace Altenic\MaybeCms\Http\Controllers;

use Altenic\MaybeCms\Models\Page;
use Altenic\MaybeCms\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        return view('maybecms::index', [
            'page' => Page::query()->findOrFail(Setting::query()->where('slug', 'home_page')->firstOrFail()->value),
        ]);
    }

    /**
     * @param string $slug
     * @return Factory|View|Application
     */
    public function show(string $slug): Factory|View|Application
    {
        return view('maybecms::index', [
            'page' => Page::query()->where('slug', $slug)->firstOrFail(),
        ]);
    }
}
