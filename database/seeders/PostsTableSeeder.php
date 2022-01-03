<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $athorId = User::where('email', 'email@example.com')->first()->id;

        // Create 5 product records
        for ($i = 0; $i < 5; $i++) {
            $post = Post::create([
                'content' => $faker->paragraph,
                'author_id' => "$athorId",
            ]);
        }
    }
}
