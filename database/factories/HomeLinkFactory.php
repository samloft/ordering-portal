<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\HomeLink::class, static function (Faker $faker) {
    return [
        'type' => $faker->word,
        'name' => $faker->name,
        'image' => $faker->word,
        'link' => $faker->word,
        'file' => $faker->word,
        'position' => $faker->randomNumber(),
        'style' => $faker->word,
    ];
});
