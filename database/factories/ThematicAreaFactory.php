<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use Faker\Generator as Faker;

$factory->define(\App\Models\ThematicArea::class, function (Faker $faker) {
    return [
        'name'=> $faker->word,
        'description'=> $faker->sentence(2),
        'updated_at' => null,
    ];
});
