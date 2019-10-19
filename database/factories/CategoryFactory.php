<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, static function (Faker $faker) {
    $categories = [
        'Category 1',
        'Category 2',
        'Category 3',
        'Category 4',
        'Category 5'
    ];

    return [
        'product' => $faker->randomNumber(8),
        'level_1' => $faker->randomElement($array = $categories),
        'level_2' => $faker->randomElement($array = $categories),
        'level_3' => $faker->randomElement($array = $categories),
    ];
});
