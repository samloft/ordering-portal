<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\DeliveryMethod::class, static function (Faker $faker) {
    return [
        'code' => $faker->word,
        'title' => $faker->word,
        'identifier' => $faker->word,
        'price_low' => $faker->randomNumber(),
        'price' => $faker->randomNumber(),
    ];
});
