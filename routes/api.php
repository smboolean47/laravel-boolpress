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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// api/posts
Route::get("/posts", "Api\PostController@index");
Route::get("/posts/{slug}", "Api\PostController@show");

// api/categories
Route::get("/categories", "Api\CategoryController@index");
Route::get("/categories/{slug}", "Api\CategoryController@show");

// api/comments
Route::post("/comments", "Api\CommentController@store");