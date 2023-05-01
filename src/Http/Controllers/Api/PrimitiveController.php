<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;

class PrimitiveController extends Controller
{
    public function index()
    {
        return response()->json(maybe_primitives());
    }
}
