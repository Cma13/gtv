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
	        'description' => fake()->sentence(5),
	        'verified' => true,
		    'format' => fake()->randomElement(['mp4', 'mov', 'ogg']),
		    'channelMode' => fake()->randomElement(['stereo', 'mono']),
		    'resolution' => fake()->randomElement(['640x480', '1280x720', '1920x1080']),
        ];
    }
}
