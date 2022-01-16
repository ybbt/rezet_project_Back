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
        // dd($request);
        $path = $request->photo->store('images');
        return Storage::disk('local')->get($path);
        return $path;
        dd($path);
    }

    public function getAvatar()
    {
        // dd($request);
        return Storage::disk('local')->get('images/oe4icjnf0NawQjixlYjvbwPPKONs2u0RwsQkpmgI.png');
        return response()->file('/images/oe4icjnf0NawQjixlYjvbwPPKONs2u0RwsQkpmgI.png');
        // dd($path);
    }
}
