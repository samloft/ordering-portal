<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, static function (Faker $faker) {
    return [
        'product' => $faker->word,
        'level_1' => $faker->word,
        'level_2' => $faker->word,
        'level_3' => $faker->word,
        'level_4' => $faker->word,
        'level_5' => $faker->word,
    ];
});
