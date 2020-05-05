<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\CategoryImage::class, static function (Faker $faker) {
    return [
        'image' => $faker->word,
        'level_1' => $faker->word,
        'level_2' => $faker->word,
        'level_3' => $faker->word,
    ];
});
