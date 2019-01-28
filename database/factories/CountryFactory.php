<?php

use Faker\Generator as Faker;

$factory->define(App\Country::class, function (Faker $faker) {
    return [
        'title'=> $faker->unique()->country(),
    ];
});