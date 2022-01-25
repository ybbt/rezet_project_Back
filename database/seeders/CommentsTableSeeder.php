<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        // Create 5 product records
        for ($i = 0; $i < 3; $i++) {
            Comment::create([
                'content' => $faker->paragraph,
                'post_id' => Post::all()->random()->id,
                'author_id' => User::all()->random()->id,
            ]);
        }

        Comment::factory()->count(3)->create();
    }
}
