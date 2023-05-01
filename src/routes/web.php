<?php

use Altenic\MaybeCms\Http\Controllers\ComponentController;
use Altenic\MaybeCms\Http\Controllers\PageController;
use Altenic\MaybeCms\Http\Controllers\PostController;
use Altenic\MaybeCms\Http\Controllers\PresetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::any('/admin/{any?}', function () {
    return view('maybecms::admin.index');
})->where('any', '.*');
Route::get('/', [PageController::class, 'index']);
Route::get('/presets/{id}', [PresetController::class, 'show']);
Route::get('/components/{id}', [ComponentController::class, 'show']);
Route::get('/{slug}', [PageController::class, 'show']);
Route::get('/{postType}/{slug}', [PostController::class, 'show']);
