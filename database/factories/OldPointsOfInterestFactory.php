<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(PointOfInterest::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'distance' => $faker->randomNumber(2),
        'latitude' => $faker->latitude(3, 20),
        'longitude' => $faker->longitude(3, 20),
        'creator'=> $faker->randomElement(User::all()->pluck('id')->toArray()),
        'updater' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'place_id'=>$faker->randomElement(Place::all()->pluck('id')->toArray()),
        'verified' => true
    ];
});
