<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $first_name = $this->faker->firstName();
        return [
            'first_name' => $first_name,
            'last_name' => $this->faker->lastName(),
            'avatar_path' => "avatars/" . $this->faker->image('storage/app/avatars', 1600, 1600, null, false, false, $first_name),
            'background_path' => "backgrounds/" . $this->faker->image('storage/app/backgrounds', 720, 120, null, false, false, false),
            'lat' => $this->faker->latitude(46, 49),
            'lng' => $this->faker->longitude(25, 37),
        ];
    }
}
