<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\ImageController;
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

//Route::post('postQuotes', [QuotesController::class, 'store']);

Route::apiResource('postQuotes', QuotesController::class);
Route::apiResource('clientImages', ImageController::class);
Route::get('clientPostedImages/{request_id}', [ImageController::class,'getUpdatedImages']);
Route::get('notify/{request_id}', [ImageController::class,'notifyUser']);
Route::get('download/{imgPath}', [ImageController::class,'downloadImg']);