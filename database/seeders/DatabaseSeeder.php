<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        // \App\Models\User::factory(10)->create();

        // $faker = \Faker\Factory::create();

        $users = User::factory()->count(4)->create();
        $userExample = User::factory()->create(['email' => "email@example.com", 'password' => 'qweasdzxc']);
        $users->push($userExample);
        $users->each(function ($user) use ($users) {
            Profile::factory()->for($user)->create();
            $posts = Post::factory()->count(rand(2, 10))->for($user, "author")->create();
            $posts->each(function ($post) use ($users) {
                for ($i = 0; $i < rand(1, 6); $i++) {
                    Comment::factory()->for($post)->for($users->random(), "author")->create();
                }
            });
        });
    }
}
