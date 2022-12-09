<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Place::factory(10)->create();
    }
}
