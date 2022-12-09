<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Place>
 */
class PlaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
	        'name'=> fake()->city(),
	        'description' => fake()->sentence(5),
	        'creator' => User::Verified()->inRandomOrder()->first()->id,
	        'updater' => User::Verified()->inRandomOrder()->first()->id,
	        'verified' => true
        ];
    }
}
