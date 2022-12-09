<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VideoItem>
 */
class VideoItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
	    $qualities = array('360p', '480p', '720p', '1080p', '4K');
	    $formats = array('avi', 'mp4', 'ogg');
	    $orientations = array('horizontal', 'vertical');
	    return [
		    'quality' => fake()->randomElement($qualities),
		    'format' => fake()->randomElement($formats),
		    'orientation' => fake()->randomElement($orientations),
		    'video_id' => Video::inRandomOrder()->first()->id,
	    ];
    }
}
