<?php

namespace Database\Seeders;

use App\Models\PointOfInterest;
use App\Models\ThematicArea;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PointOfInterestSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $pointsOfInterest = PointOfInterest::factory(20)->make();
        $pointsOfInterest->each(function($pointOfInterest) {
            $pointOfInterest->save();
            $thematicAreas= ThematicArea::all()->pluck('id')->toArray();
            $pointOfInterest->thematicAreas()->attach(Arr::random($thematicAreas, 2),
                [
                    'title' => fake()->sentence,
                    'description' => fake()->text,
                ]);
        });
    }
}
