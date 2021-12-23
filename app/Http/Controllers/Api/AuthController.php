<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(/* Request $request */RegisterRequest $request)
    {

        $credentials = $request->validated();

        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create(/* $input */$credentials);

        $token = $user->createToken($request->email)->plainTextToken;


        return response()->json(['token' => $token], Response::HTTP_OK);
    }



    public function login(/* Request $request */LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::once($credentials)) {

            $token = Auth::user()->createToken(Auth::user()->email)->plainTextToken;
            return response()->json([
                'success' => true,
                'token' => $token,
            ]);
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
        // Auth::logout();
        $request->user()->currentAccessToken()->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
