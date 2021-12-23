<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostRequest;
// use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //        dd("index");
        // return PostResource::collection(Post::all());
        $posts = Post::with('user:id,name')->get();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        //        dd(auth()->user()->posts()->create($request->all()));
        //         $created_post = Post::create($request->all());
        $created_post = auth()->user()->posts()->create($data);



        return new PostResource($created_post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $data = $request->validated();
        $user = Auth::user();

        if ($user->can('update', $post)) {
            $post->update($data);
            return new PostResource($post);
        } else {
            return response()->json(['succes' => false], Response::HTTP_FORBIDDEN);
        }

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $user = Auth::user();
        if ($user->can('delete', $post)) {

            $post->delete();
            return response()->json(['succes' => true], Response::HTTP_NO_CONTENT);
        } else {
            return response()->json(['succes' => false], Response::HTTP_FORBIDDEN);
        }
    }
}
