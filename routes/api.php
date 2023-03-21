<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\Api\V2\AuthApiController as AuthApiControllerV2;

use App\Http\Controllers\Api\V1\PostCommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthApiController::class, 'register']);
Route::post('/login',[AuthApiController::class, 'login']);

Route::prefix('v2')->group(function (){
    Route::post('/register',[AuthApiControllerV2::class, 'register']);
    Route::post('/login',[AuthApiControllerV2::class, 'login']);
});


Route::prefix('v1')->middleware('auth:sanctum')->name('api.v1.')->group(function (){
    Route::apiResource('post.comments',PostCommentController::class);
});


Route::prefix('v2')->middleware('auth:api')->name('api.v2.')->group(function (){
    Route::apiResource('post.comments',PostCommentController::class);
});

Route::fallback(function () {
    return response()->json([
        'message'=>'Not found'
    ], 404);
})->name('api.fallback');

