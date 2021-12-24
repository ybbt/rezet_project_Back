<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\PostController;
use \App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\UserController;
use \App\Models\User;



// header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization');

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


// Route::apiResources([
//     'posts' => PostController::class,
// ]);

// Route::group(['middleware' => ['auth:sanctum']], function () {
//     Route::apiResources([
//         'posts' => PostController::class,
//     ]);
// });

Route::get('/posts', [PostController::class, "index"]);
Route::get('/posts/{post}', [PostController::class, "show"]);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::get('/users/{user}/posts', [UserController::class, 'user_posts']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/posts', [PostController::class, "store"]);
    Route::put('/posts/{post}', [PostController::class, "update"]);
    Route::delete('/posts/{post}', [PostController::class, "destroy"]);
});

Route::namespace('Api')->group(function () {
    Route::post('register', [AuthController::class, 'register']); // * правильний
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('authme', [AuthController::class, 'authme']); // * правильний
});
