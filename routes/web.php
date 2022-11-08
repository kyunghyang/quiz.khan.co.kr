<?php

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

Route::get("/share/{path}/{test1}", function(){
    $path = str_replace("share", "", request()->path());

    $url = config("app.parent_url").$path;

    return redirect($url);
});
Route::get("/share/{path}/{test1}/{test2}", function(){
    $path = str_replace("share", "", request()->path());

    $url = config("app.parent_url").$path;

    return redirect($url);
});
Route::get("/share/{path}/{test1}/{test2}/{test3}", function(){
    $path = str_replace("share", "", request()->path());

    $url = config("app.parent_url").$path;

    return redirect($url);
});

Route::get("/share/{path}/{test1}/{test2}/{test3}/{test4}", function(){
    $path = str_replace("share", "", request()->path());

    $url = config("app.parent_url").$path;

    return redirect($url);
});

Route::get("/share/{path}", function(){
    $path = str_replace("share", "", request()->path());

    $url = config("app.parent_url").$path;

    return redirect($url);
});


Route::middleware("auth")->group(function(){
});


Route::middleware("auth")->group(function(){
    Route::get("/logout", [\App\Http\Controllers\UserController::class, "logout"]);
});

Route::get("/mailable", function(){
});

Route::get("/answers", [\App\Http\Controllers\AnswerController::class, "index"]);
Route::get("/pointHistories", [\App\Http\Controllers\PointHistoryController::class, "index"]);

Route::middleware("auth")->group(function(){


});

// 원래 auth 시작
Route::post("/newspapers", [\App\Http\Controllers\NewspaperController::class, "store"]);
Route::delete("/newspapers", [\App\Http\Controllers\NewspaperController::class, "destroy"]);
Route::patch("/newspapers/{newspaper}/next", [\App\Http\Controllers\NewspaperController::class, "next"]);
Route::patch("/newspapers/{newspaper}/prev", [\App\Http\Controllers\NewspaperController::class, "prev"]);
Route::patch("/newspapers", [\App\Http\Controllers\NewspaperController::class, "updateAll"]);


Route::get("/readHistories", [\App\Http\Controllers\ReadHistoryController::class, "index"]);
Route::get("/readHistories/create", [\App\Http\Controllers\ReadHistoryController::class, "create"]);
Route::post("/readHistories", [\App\Http\Controllers\ReadHistoryController::class, "store"]);
Route::get("/newspapers/create", [\App\Http\Controllers\NewspaperController::class, "create"]);

Route::get("/curations", [\App\Http\Controllers\CurationController::class, "index"]);
Route::patch("/curations", [\App\Http\Controllers\CurationController::class, "updateAll"]);
Route::patch("/curations/updateMemo/{curation}", [\App\Http\Controllers\CurationController::class, "updateMemo"]);
Route::patch("/curations/{curation}", [\App\Http\Controllers\CurationController::class, "update"]);
Route::post("/curations", [\App\Http\Controllers\CurationController::class, "store"]);
Route::delete("/curations", [\App\Http\Controllers\CurationController::class, "destroy"]);

Route::patch("/users/template", [\App\Http\Controllers\UserController::class, "updateTemplate"]);
Route::get("/questions", [\App\Http\Controllers\QuestionController::class, "index"]);
Route::post("/answers", [\App\Http\Controllers\AnswerController::class, "store"]);

// 원래 auth 끝
Route::get("/curations/{id}", [\App\Http\Controllers\CurationController::class, "show"]);
Route::get("/answers/questions", [\App\Http\Controllers\AnswerController::class, "questions"]);
Route::get("/answers/create", [\App\Http\Controllers\AnswerController::class, "create"]);
Route::get("/answers/{id}", [\App\Http\Controllers\AnswerController::class, "show"]);



Route::middleware("guest")->group(function(){
    Route::get("/login", [\App\Http\Controllers\UserController::class, "loginForm"])->name("login");
    Route::post("/login", [\App\Http\Controllers\UserController::class, "login"]);
    Route::post("/register", [\App\Http\Controllers\UserController::class, "register"]);
    // Route::resource("/users", \App\Http\Controllers\UserController::class);
});

