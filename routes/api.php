<?php

use Illuminate\Http\Request;
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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::get("/123", [\App\Http\Controllers\Api\UserController::class, "show"]);

Route::middleware('auth')->group(function () {

});

Route::get("/users", [\App\Http\Controllers\Api\UserController::class, "show"]);
Route::post("/readHistories", [\App\Http\Controllers\Api\ReadHistoryController::class, "store"]);
Route::post("/answers", [\App\Http\Controllers\Api\AnswerController::class, "store"]);
Route::post("/newspapers", [\App\Http\Controllers\Api\NewspaperController::class, "store"]);


