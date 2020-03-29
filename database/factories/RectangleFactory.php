<?php

/** @var Factory $factory */

use App\Models\Color;
use App\Models\Shapes\Rectangle;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Rectangle::class, function (Faker $faker) {
    return [
        'width' => (float) rand(20, 100),
        'height' => (float) rand(20, 100),
        'color_id' => Color::query()->inRandomOrder()->first()->id,
        'user_id' => User::query()->inRandomOrder()->first()->id
    ];
});
