<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return new ProfileResource(auth()->user()->profile);
    }

    public function newAvatar(Request $request)
    {
        // dd($request->photo);
        $path = $request->avatar->store('avatars');
        // return Storage::disk('local')->get($path);
        Storage::delete(auth()->user()->profile->avatar_path);
        $avatar_path = ["avatar_path" => $path];
        auth()->user()->profile()->update($avatar_path);
        return $path;
    }

    public function getAvatar()
    {
        // dd(auth()->user()->profile->avatar_path);
        // return Storage::disk('local')->get('images/GNSLdsM61xCf7dqvXmwOpYqu3xgiyXoAxTc9VbQU.png');
        // $url = Storage::url("ii6M2s2obYHY6P8nWD6oFQTfKq17sboVLBC54wod.png");
        // dd($url);
        // return response()->file('/images/oe4icjnf0NawQjixlYjvbwPPKONs2u0RwsQkpmgI.png');
        return response(auth()->user()->profile->avatar_path);
    }

    public function deleteAvatar()
    {
        Storage::delete(auth()->user()->profile->avatar_path);
        $avatar_path = ["avatar_path" => null];
        auth()->user()->profile()->update($avatar_path);
    }
}
