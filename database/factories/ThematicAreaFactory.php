<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ThematicArea>
 */
class ThematicAreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
	        'name'=> fake()->word,
	        'description'=> fake()->sentence(5),
	        'updated_at' => null,
        ];
    }
}
