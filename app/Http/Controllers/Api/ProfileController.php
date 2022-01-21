<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return response($request["first_name"]);
        // dd($request["first_name"]);
        // dd(auth()->user()->profile);

        // if ($request["avatar"] !== null) {
        //     $path = $request->avatar->store('avatars');
        //     $request["avatar_path"] = $path;
        // }
        $profile = auth()->user()->profile->update($request->all()/* validated() */);
        return $profile;

        // return new PostResource($post);

    }

    public function newAvatar(Request $request)
    {
        // dd($request);
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

    public function updateLocation(Request $request)
    {
    }
}
