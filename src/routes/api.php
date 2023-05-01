<?php

use Altenic\MaybeCms\Http\Controllers\Api\AuthController;
use Altenic\MaybeCms\Http\Controllers\Api\BlockController;
use Altenic\MaybeCms\Http\Controllers\Api\ComponentController;
use Altenic\MaybeCms\Http\Controllers\Api\FieldTypeController;
use Altenic\MaybeCms\Http\Controllers\Api\FileController;
use Altenic\MaybeCms\Http\Controllers\Api\PostTypeController;
use Altenic\MaybeCms\Http\Controllers\Api\PageController;
use Altenic\MaybeCms\Http\Controllers\Api\PostController;
use Altenic\MaybeCms\Http\Controllers\Api\PresetController;
use Altenic\MaybeCms\Http\Controllers\Api\PrimitiveController;
use Altenic\MaybeCms\Http\Controllers\Api\RelationTypeController;
use Altenic\MaybeCms\Http\Controllers\Api\SettingController;
use Altenic\MaybeCms\Http\Middleware\HeadersMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/api')->middleware([HeadersMiddleware::class, 'api'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/settings', [SettingController::class, 'index']);
        Route::post('/settings', [SettingController::class, 'update']);

        Route::get('/pages', [PageController::class, 'index']);
        Route::get('/pages/{page}', [PageController::class, 'show']);
        Route::post('/pages', [PageController::class, 'store']);
        Route::post('/pages/{page}', [PageController::class, 'update']);
        Route::delete('/pages/{page}', [PageController::class, 'destroy']);

        Route::get('/blocks/{block}', [BlockController::class, 'show']);
        Route::post('/blocks', [BlockController::class, 'store']);
        Route::post('/blocks/{block}/clone', [BlockController::class, 'clone']);
        Route::delete('/blocks/{block}', [BlockController::class, 'destroy']);
        Route::post('/blocks/{block}/post-type/{postType}', [BlockController::class, 'setPostType']);
        Route::delete('/blocks/{block}/post-type', [BlockController::class, 'unsetPostType']);

        Route::get('/files', [FileController::class, 'index']);
        Route::post('/files', [FileController::class, 'store']);
        Route::get('/files/{file}', [FileController::class, 'show']);
        Route::delete('/files/{file}', [FileController::class, 'destroy']);

        Route::get('/presets', [PresetController::class, 'index']);
        Route::get('/presets/{preset}', [PresetController::class, 'show']);
        Route::post('/presets', [PresetController::class, 'store']);
        Route::post('/presets/{preset}', [PresetController::class, 'update']);
        Route::post('/presets/{preset}/apply', [PresetController::class, 'apply']);
        Route::delete('/presets/{preset}', [PresetController::class, 'destroy']);

        Route::get('/components', [ComponentController::class, 'index']);
        Route::get('/components/{component}', [ComponentController::class, 'show']);
        Route::post('/components', [ComponentController::class, 'store']);
        Route::post('/components/{component}', [ComponentController::class, 'update']);
        Route::post('/components/{component}/apply', [ComponentController::class, 'apply']);
        Route::delete('/components/{component}', [ComponentController::class, 'destroy']);

        Route::get('/post-types', [PostTypeController::class, 'index']);
        Route::get('/post-types/{postType}', [PostTypeController::class, 'show']);
        Route::post('/post-types', [PostTypeController::class, 'store']);
        Route::post('/post-types/{postType}', [PostTypeController::class, 'update']);
        Route::delete('/post-types/{postType}', [PostTypeController::class, 'destroy']);

        Route::get('/primitives', [PrimitiveController::class, 'index']);
        Route::get('/field-types', [FieldTypeController::class, 'index']);
        Route::get('/relation-types', [RelationTypeController::class, 'index']);


        Route::get('/posts/{postType}', [PostController::class, 'index']);
        Route::get('/posts/{postType}/{post}', [PostController::class, 'show']);
        Route::post('/posts/{postType}', [PostController::class, 'store']);
        Route::post('/posts/{postType}/{post}', [PostController::class, 'update']);
        Route::delete('/posts/{postType}/{post}', [PostController::class, 'destroy']);
    });
});
