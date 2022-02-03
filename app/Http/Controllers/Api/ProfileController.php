<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdateBackgroundRequest;
use App\Http\Requests\UpdateCredentialsRequest;
use App\Http\Requests\UpdateLocationRequest;
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
    public function update(UpdateCredentialsRequest $request)
    {
        // return response($request["first_name"]);
        // dd($request["first_name"]);
        // dd(auth()->user()->profile);
        // dd($request->all());

        // if ($request["avatar"] !== null) {
        //     $path = $request->avatar->store('avatars');
        //     $request["avatar_path"] = $path;
        // }
        // dd($request->validated());
        auth()->user()->profile->update($request->validated());
        return new ProfileResource(auth()->user()->profile()->first());
    }

    public function newAvatar(UpdateAvatarRequest $request)
    {
        $avatar = $request->validated();
        // dd(($avatar));
        if (count($avatar) === 0) {
            Storage::delete(auth()->user()->profile->avatar_path);
            $avatar_path = ["avatar_path" => null];
            auth()->user()->profile()->update($avatar_path);
            // response()->noContent();
        } else {
            $path = $request->avatar->store('avatars');
            // return Storage::disk('local')->get($path);
            Storage::delete(auth()->user()->profile->avatar_path);
            $avatar_path = ["avatar_path" => $path];
            auth()->user()->profile()->update($avatar_path);
        }
        return new ProfileResource(auth()->user()->profile()->first());
    }

    public function newBackground(UpdateBackgroundRequest $request)
    {
        $background = $request->validated();
        // dd((count($background)));
        // return ($background["background"]);
        if (count($background) === 0) {
            Storage::delete(auth()->user()->profile->background_path);
            $background_path = ["background_path" => null];
            auth()->user()->profile()->update($background_path);
            // response()->noContent();
        } else {
            $path = $request->background->store('backgrounds');
            // return Storage::disk('local')->get($path);
            Storage::delete(auth()->user()->profile->background_path);
            $background_path = ["background_path" => $path];
            auth()->user()->profile()->update($background_path);
        }
        return new ProfileResource(auth()->user()->profile()->first());
    }

    // // --- тимчасово для тесту
    // public function getAvatar()
    // {
    //     // dd(auth()->user()->profile->avatar_path);
    //     // return Storage::disk('local')->get('images/GNSLdsM61xCf7dqvXmwOpYqu3xgiyXoAxTc9VbQU.png');
    //     // $url = Storage::url("ii6M2s2obYHY6P8nWD6oFQTfKq17sboVLBC54wod.png");
    //     // dd($url);
    //     // return response()->file('/images/oe4icjnf0NawQjixlYjvbwPPKONs2u0RwsQkpmgI.png');
    //     $url = asset(auth()->user()->profile->avatar_path);
    //     return response($url);
    // }

    // public function deleteAvatar()
    // {
    //     Storage::delete(auth()->user()->profile->avatar_path);
    //     $avatar_path = ["avatar_path" => null];
    //     auth()->user()->profile()->update($avatar_path);
    // }

    public function updateLocation(UpdateLocationRequest $request)
    {

        auth()->user()->profile()->update($request->validated());
        return new ProfileResource(auth()->user()->profile()->first());
    }
}
