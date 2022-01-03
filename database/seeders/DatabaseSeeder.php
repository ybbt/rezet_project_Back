<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
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
        User::factory()->count(10)->has(Post::factory()->count(5)->has(Comment::factory()->count(10)))->create();
    }
}
