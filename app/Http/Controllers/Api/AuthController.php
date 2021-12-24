<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $credentials = $request->validated();

        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json(['token' => $token], Response::HTTP_OK);
    }



    public function login(LoginRequest $request)
    {
        $request->validated();
        $credentials = ['password' => $request->password];
        if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->login;
        } else {
            $credentials['name'] = $request->login;
        }

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken(Auth::user()->email)->plainTextToken;
            return response()->json([
                'success' => true,
                'token' => $token,
            ], Response::HTTP_OK);
        } else {
            return response()->json(['succes' => false], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function authme(Request $request)
    {
        return new AuthResource($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['succes' => true], Response::HTTP_NO_CONTENT);
    }
}
