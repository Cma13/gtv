<?php



namespace Database\Factories;

use App\Models\Place;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Place::class, function (Faker $faker) {
    return [
        'name'=> $faker->city,
        'description' => $faker->sentence(5),
        'creator' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'updater' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'verified' => true
    ];
});
