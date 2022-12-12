<?php

namespace Database\Seeders;

use App\Models\ThematicArea;
use Illuminate\Database\Seeder;

class ThematicAreaSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        ThematicArea::factory(10)->create();
    }
}
