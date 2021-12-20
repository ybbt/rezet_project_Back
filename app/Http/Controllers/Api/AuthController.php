<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8']
        ]);
        //* 1
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        //* 2    

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        //* 3    

        $token = $user->createToken($request->email)->plainTextToken;
        //* 4    

        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        // 1

        $user = User::where('email', $request->email)->first();
        // 2

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
        }
        // 3

        return response()->json(['token' => $user->createToken($request->email)->plainTextToken]);
        // 4
    }

    public function login(Request $request)
    {
        // $info = [
        //     'success' => false,
        //     'token' => null,
        // ];

        $user = User::where('name', $request->name)->first();

        // dd($user->tokens()->first()->to);

        if (!empty($user) && Hash::check($request->password, $user->password)) {
            // $info['success'] = true;
            $token = $user->createToken($user->email)->plainTextToken;

            // dd($token);
            return [
                'success' => true,
                'token' => $token,
            ];
        } else {
            return [
                'success' => false,
            ];
        }
    }
}
