<?php

/** @var Factory $factory */

use App\Models\Shapes\Circle;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Circle::class, function (Faker $faker) {
    return [
        'radius' => (float) rand(5, 75),
        'color_id' => rand(1, 3)
    ];
});
