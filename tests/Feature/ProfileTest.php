<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getMe()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('api/me');
        // dd($response);

        $response->assertUnauthorized(); //ssertStatus(200);->status()
    }

    public function test_updateAvatar()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('api/me/avatar');
        // dd($response);

        $response->assertUnauthorized();
    }

    public function test_updateBackground()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('api/me/background');
        // dd($response);

        $response->assertUnauthorized();
    }

    public function test_updateCredentials()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('api/me/credentials');
        // dd($response);

        $response->assertUnauthorized();
    }

    public function test_updateLocation()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('api/me/location');
        // dd($response);

        $response->assertUnauthorized();
    }

    public function test_getPosts()
    {
        // $post = Post::factory()->count(3)->make();
        $this->seed();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('api/posts');
        dd($response);

        $response->assertOk();
    }
}
