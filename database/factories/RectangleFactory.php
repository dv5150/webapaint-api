<?php

/** @var Factory $factory */

use App\Models\Shapes\Rectangle;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Rectangle::class, function (Faker $faker) {
    return [
        'width' => (float) rand(20, 100),
        'height' => (float) rand(20, 100),
        'color_id' => rand(1, 3)
    ];
});
