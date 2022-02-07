<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

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
        $avatar = $this->faker->image(null, 1600, 1600, null, true, false, $first_name);
        // $avatarFile = new File($avatar);
        $background = $this->faker->image(null, 720, 120, "BG", true, false);
        // $backgroundFile = new File($background);
        return [
            'first_name' => $first_name,
            'last_name' => $this->faker->lastName(),
            'avatar_path' => /* "avatars/" .  */ Storage::disk('local')->putFile('avatars',  new File($avatar)),
            //$this->faker->image('public/avatars', 1600, 1600, null, false, false, $first_name),
            'background_path' => /* "backgrounds/" .  */ Storage::disk('local')->putFile('backgrounds', new File($background)),
            // $this->faker->image('public/backgrounds', 720, 120, null, false, false, false),
            'lat' => $this->faker->latitude(46, 49),
            'lng' => $this->faker->longitude(25, 37),
        ];
    }
}
