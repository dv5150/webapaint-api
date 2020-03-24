<?php

/** @var Factory $factory */

use App\Models\Worksheet;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Worksheet::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true)
    ];
});
