<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $userId = User::where('email', 'email@example.com')->first()->id;

        Profile::create([
            'user_id' => $userId,
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),

        ]);
    }
}
