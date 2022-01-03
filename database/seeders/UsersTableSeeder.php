<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        User::create([
            'name' => $faker->unique()->firstName(),
            'email' => "email@example.com",
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email_verified_at' => now(),
            'password' => 'qweasdzxc',
            'remember_token' => Str::random(10),
        ]);
    }
}
