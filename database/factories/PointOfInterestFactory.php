<?php

namespace Database\Factories;

use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PointOfInterest>
 */
class PointOfInterestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
			'name' => fake()->city(),
	        'latitude' => fake()->latitude(-70, 70),
	        'longitude' => fake()->longitude(),
	        'creator'=> User::Verified()->inRandomOrder()->first()->id,
	        'updater' => User::Verified()->inRandomOrder()->first()->id,
	        'place_id'=> Place::inRandomOrder()->first()->id,
	        'verified' => true,
        ];
    }
}
