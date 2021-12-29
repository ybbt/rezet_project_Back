<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

//use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        // $credentials = $request->validated();

        $user = User::create($request->validated());
        $token = $user->createToken($request->header('User-Agent'))->plainTextToken;

        return response()->json(['token' => $token], Response::HTTP_OK);
    }



    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->getCredentials())) {
            $token = Auth::user()->createToken($request->header('User-Agent'))->plainTextToken;
            return response()->json([
                'token' => $token,
            ]);
        } else {
            // return response()->json(null, Response::HTTP_UNAUTHORIZED);
            throw ValidationException::withMessages(["Authorization denied. Сheck the correctness of the entered data"]);
        }
    }


    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
