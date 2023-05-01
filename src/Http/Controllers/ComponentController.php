<?php

namespace Altenic\MaybeCms\Http\Controllers;

use Altenic\MaybeCms\Models\Component;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ComponentController extends Controller
{
    /**
     * @param $id
     * @return Factory|View|Application
     */
    public function show($id): Factory|View|Application
    {
        return view('maybecms::component', [
            'component' => Component::query()->findOrFail($id),
        ]);
    }
}
