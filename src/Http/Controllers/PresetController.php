<?php

namespace Altenic\MaybeCms\Http\Controllers;

use Altenic\MaybeCms\Models\Preset;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PresetController extends Controller
{
    /**
     * @param $id
     * @return Factory|View|Application
     */
    public function show($id): Factory|View|Application
    {
        return view('maybecms::preset', [
            'preset' => Preset::query()->findOrFail($id),
        ]);
    }
}
