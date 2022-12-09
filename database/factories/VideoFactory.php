<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PointOfInterest;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
	    $pointOfInterest = PointOfInterest::inRandomOrder()->first();
	    return [
	        'route' => 'videos/' . fake()->uuid() . '.mp4',
	        'point_of_interest_id' => $pointOfInterest->id,
	        'order' => 1 + $pointOfInterest->videos->count(),
	        'creator' => User::Verified()->inRandomOrder()->first()->id,
	        'updater' => null,
	        'thematic_area_id' => $pointOfInterest->thematicAreas->shuffle()->first()->id,
	        'description' => fake()->sentence(5),
	        'verified' => true,
        ];
    }
}
