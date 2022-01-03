<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\PostController;
use \App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use \App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommentController;

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

Route::get('/posts', [PostController::class, "index"]);
Route::get('/posts/{post}', [PostController::class, "show"]);
Route::get('/users/{user:name}', [UserController::class, 'show']);
Route::get('/users/{user:name}/posts', [PostController::class, 'getAllUserPosts']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/posts/{post}/comments', [CommentController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/posts', [PostController::class, "store"]);
    Route::put('/posts/{post}', [PostController::class, "update"])->can('update', 'post');
    Route::delete('/posts/{post}', [PostController::class, "destroy"])->can('delete', 'post');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [ProfileController::class, 'show']);

    Route::post('/posts/{post}/comments', [CommentController::class, "store"]);
    Route::put('/comments/{comment}', [CommentController::class, "update"])->can('update', 'comment');
    Route::delete('/comments/{comment}', [CommentController::class, "destroy"])->can('delete', 'comment');
});
