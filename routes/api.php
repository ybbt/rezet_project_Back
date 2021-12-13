<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\PostController;
use \App\Http\Controllers\Api\AuthController;
use \App\Models\User;

// ! Убрати, коли перенесу в контролер
use Illuminate\Support\Facades\Hash;

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

// Route::get('/posts', [PostController::class, index]);

Route::apiResources([
    'posts' => PostController::class,
]);

Route::namespace('Api')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('token', [AuthController::class, 'token']);
});

Route::middleware('auth:sanctum')->get('/name', function (Request $request) {
    return response()->json(['name' => $request->user()->name]);
});

Route::post('login-verify', function (Request $request) {

    $info = [
        'success' => false,
        'token' => null,
    ];

    $user = User::where('name', $request->username)->first();

    if (!empty($user) && Hash::check($request->password, $user->password)) {
        $info['success'] = true;
        $token = $user->createToken($user->email)->plainTextToken;

        // ******* Для теста в кукисами
        $cookie = cookie('token_laravel', $token, 360000);
        // return response([
        //     'success' => true,
        //     'token' => $token,
        // ])->withCookie($cookie);
        $value = $request->cookie('token_mytweeter');
        // echo $value;

        return [
            'success' => true,
            'token' => $token,
            'cookiess' => $value,
        ];
    } else {
        return [
            'success' => false,
        ];
    }
});

Route::middleware('auth:sanctum')->get('/auth-user', function (Request $request) {
    return $request->user();
});
