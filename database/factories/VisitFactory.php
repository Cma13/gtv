<?php

namespace Database\Factories;

use App\Models\PointOfInterest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
	        'hour' => fake()->dateTime(),
	        'deviceid' => fake()->uuid(),
	        'appversion' => fake()->numberBetween(1, 10),
	        'useragent' => fake()->userAgent(),
	        'ssoo' => fake()->word(),
	        'ssooversion' => fake()->numberBetween(1, 10),
	        'latitude' => fake()->latitude(-70, 70),
	        'longitude' => fake()->longitude,
	        'point_of_interest_id' => PointOfInterest::inRandomOrder()->first()->id,
        ];
    }
}
