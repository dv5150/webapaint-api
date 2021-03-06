<?php

/** @var Factory $factory */

use App\Models\Color;
use App\Models\Shapes\Circle;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Circle::class, function (Faker $faker) {
    return [
        'radius' => (float) rand(5, 75),
        'color_id' => Color::query()->inRandomOrder()->first()->id,
        'user_id' => User::query()->inRandomOrder()->first()->id
    ];
});
