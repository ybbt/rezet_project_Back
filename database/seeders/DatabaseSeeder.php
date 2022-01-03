<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        // $this->call(CommentsTableSeeder::class);

        // User::factory()->count(10)->has(Post::factory()->count(5)->has(Comment::factory()/* ->for(User::all()->random())*/->count(3)))->create();

        // Comment::factory()->for(User::factory()->count(10)->count(3))->create();

        User::factory()->count(10)->has(Post::factory()->count(5)->has(Comment::factory()->count(3)->state(new Sequence(
            fn ($sequence) => ['author_id' => User::all()->random()->id],
        ))))->create();
    }
}
