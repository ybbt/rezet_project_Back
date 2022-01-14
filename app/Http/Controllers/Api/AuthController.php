<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();
        $user = User::create($credentials);
        $user->profile()->create($credentials);
        $token = $user->createToken($request->header('User-Agent'))->plainTextToken;

        return response()->json(['token' => $token]);
    }



    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken($request->header('User-Agent'))->plainTextToken;
            return response()->json([
                'token' => $token,
            ]);
        } else {
            throw ValidationException::withMessages(["Authorization denied. Сheck the correctness of the entered data"]);
        }
    }


    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
