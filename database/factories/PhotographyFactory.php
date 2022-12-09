<?php

namespace Database\Factories;

use App\Models\PointOfInterest;
use App\Models\ThematicArea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photography>
 */
class PhotographyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
	        'route' => 'https://via.placeholder.com/640x480?text=Foto',
	        'order' => fake()->randomDigit(),
	        'point_of_interest_id' => PointOfInterest::inRandomOrder()->first()->id,
	        'thematic_area_id' => ThematicArea::inRandomOrder()->first()->id,
	        'creator' => User::Verified()->inRandomOrder()->first()->id,
	        'updater' => null,
	        'updated_at' => null,
	        'verified' => true,
        ];
    }
}
