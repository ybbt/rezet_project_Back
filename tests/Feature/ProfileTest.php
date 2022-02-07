<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use WithFaker;
    // use RefreshDatabase;
    use DatabaseTransactions;
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



    public function test_updateProfile()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('api/me/update');

        $response->assertUnauthorized();
    }

    // public function test_getPosts()
    // {
    //     // $post = Post::factory()->count(3)->make();
    //     Storage::fake('avatars');
    //     Storage::fake('backgrounds');
    //     $this->seed();
    //     $response = $this->withHeaders([
    //         'Accept' => 'application/json',
    //     ])->get('api/posts');
    //     // dd($response);

    //     $response->assertOk();
    // }

    public function setUp(): void
    {
        dump("setUUp");
        parent::setUp();
        Storage::fake('local');

        $user = User::factory()->has(Profile::factory())->create();
        $this->token = $user->createToken('token')->plainTextToken;
        $this->user = $user;

        // $this->firstName = $this->faker->firstName;
        // $this->lastName = $this->faker->lastName;
    }

    public function testGetMeProfile_Unauthorize()
    {
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])
            ->json('GET', 'api/me')
            ->assertStatus(200)
            // ->assertUnauthorized()
            ->assertJson(fn (AssertableJson $json) => $json
                ->whereType('data', 'array'));
    }


    public function test_updateProfile_newAvatar()
    {

        $oldAvatar = $this->user->profile->avatar_path;
        Storage::disk('local')->assertExists($oldAvatar);

        $file = UploadedFile::fake()->create('avatar.jpg', 9);

        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])
            ->json('POST', 'api/me/update', ['avatar' => $file])
            ->assertStatus(200)
            // ->assertUnauthorized()
            ->assertJson(fn (AssertableJson $json) => $json
                ->whereType('data', 'array')->has('data.avatar_path'));

        Storage::disk('local')->assertExists('avatars/' . $file->hashName());
        Storage::disk('local')->assertMissing($oldAvatar);

        // dd($this);
    }

    public function test_updateProfile_deleteAvatar()
    {

        $oldAvatar = $this->user->profile->avatar_path;
        Storage::disk('local')->assertExists($oldAvatar);

        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])
            ->json('POST', 'api/me/update', ['avatar' => null])
            ->assertStatus(200)
            // ->assertUnauthorized()
            ->assertJson(fn (AssertableJson $json) => $json
                ->whereType('data', 'array')->missing('data.avatar_path'));

        Storage::disk('local')->assertMissing($oldAvatar);
    }

    public function test_updateProfile_newBackground()
    {

        $oldABackground = $this->user->profile->background_path;
        Storage::disk('local')->assertExists($oldABackground);

        $file = UploadedFile::fake()->create('background.jpg', 9);

        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])
            ->json('POST', 'api/me/update', ['background' => $file])
            ->assertStatus(200)
            // ->assertUnauthorized()
            ->assertJson(fn (AssertableJson $json) => $json
                ->whereType('data', 'array')->has('data.background_path'));

        Storage::disk('local')->assertExists('backgrounds/' . $file->hashName());
        Storage::disk('local')->assertMissing($oldABackground);
    }

    public function test_updateProfile_deleteBackground()
    {

        $oldABackground = $this->user->profile->background_path;
        Storage::disk('local')->assertExists($oldABackground);

        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])
            ->json('POST', 'api/me/update', ['background' => null])
            ->assertStatus(200)
            // ->assertUnauthorized()
            ->assertJson(fn (AssertableJson $json) => $json
                ->whereType('data', 'array')->missing('data.background_path'));

        Storage::disk('local')->assertMissing($oldABackground);
    }

    public function test_updateProfile_newName()
    {
        //     $oldfirst = $this->user->profile->background_path;
        //     dump($oldfirst);

        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])
            ->json('POST', 'api/me/update', ['first_name' => $name = $this->faker->firstName(), 'last_name' => $this->faker->lastName()])
            ->assertStatus(200)
            // ->assertUnauthorized()
            ->assertJson(fn (AssertableJson $json) => $json
                ->whereType('data', 'array')->has('data.first_name')->has('data.last_name'));

        // dump($response);
        // dd($this->user->profile);
    }

    public function test_updateProfile_newName_nullable()
    {
        //     $oldfirst = $this->user->profile->background_path;
        //     dump($oldfirst);

        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])
            ->json('POST', 'api/me/update', ['first_name' => $name = null, 'last_name' => $this->faker->lastName()])->dump()
            ->assertStatus(422)
            // ->assertUnauthorized()
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('message')->has('errors'));

        // dump($response);
        // dd($this->user->profile);
    }

    public function test_updateProfile_newLocation()
    {


        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])
            ->json('POST', 'api/me/update', ['lat' => $name = $this->faker->latitude(46, 49), 'lng' => $this->faker->longitude(25, 37)])
            ->assertStatus(200)
            // ->assertUnauthorized()
            ->assertJson(fn (AssertableJson $json) => $json
                ->whereType('data', 'array')->has('data.lat')->has('data.lng'));

        dump($response);
        // dd($this->user->profile);
    }
}
