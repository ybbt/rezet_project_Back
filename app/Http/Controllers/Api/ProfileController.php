<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdateBackgroundRequest;
use App\Http\Requests\UpdateCredentialsRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Requests\UpdateProfileRequest;
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
    public function updateCredentials(UpdateCredentialsRequest $request)
    {
        auth()->user()->profile->update($request->validated());
        return new ProfileResource(auth()->user()->profile()->first());
    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $requestData = $request->validated();

        if (isset($requestData["delete"])) {
            Storage::delete(auth()->user()->profile->avatar_path);
            $avatar_path = ["avatar_path" => null];
            auth()->user()->profile()->update($avatar_path);
        } else {
            $path = $request->avatar->store('avatars');
            Storage::delete(auth()->user()->profile->avatar_path);
            $avatar_path = ["avatar_path" => $path];
            auth()->user()->profile()->update($avatar_path);
        }
        return new ProfileResource(auth()->user()->profile()->first());
    }

    public function updateBackground(UpdateBackgroundRequest $request)
    {
        $requestData = $request->validated();

        if (isset($requestData["delete"])) {
            Storage::delete(auth()->user()->profile->background_path);
            $background_path = ["background_path" => null];
            auth()->user()->profile()->update($background_path);
        } else {
            $path = $request->background->store('backgrounds');
            Storage::delete(auth()->user()->profile->background_path);
            $background_path = ["background_path" => $path];
            auth()->user()->profile()->update($background_path);
        }
        return new ProfileResource(auth()->user()->profile()->first());
    }

    public function updateLocation(UpdateLocationRequest $request)
    {

        auth()->user()->profile()->update($request->validated());
        return new ProfileResource(auth()->user()->profile()->first());
    }

    public function update(UpdateProfileRequest $request)
    {
        $profileData = $request->validated();
        if (array_key_exists('avatar', $profileData)) {
            if ($profileData["avatar"] == null) {
                $profileData["avatar_path"] = null;
            } else {
                $path = $profileData["avatar"]->store('avatars');
                $profileData["avatar_path"] = $path;
            }
            Storage::delete(auth()->user()->profile->avatar_path);
            unset($profileData["avatar"]);
        }
        if (array_key_exists('background', $profileData)) {
            if ($profileData["background"] == null) {
                $profileData["background_path"] = null;
            } else {
                $path = $profileData["background"]->store('backgrounds');
                $profileData["background_path"] = $path;
            }
            Storage::delete(auth()->user()->profile->background_path);
            unset($profileData["background"]);
        }
        auth()->user()->profile()->update($profileData/* validated() */);
        return new ProfileResource(auth()->user()->profile()->first());
    }
}
