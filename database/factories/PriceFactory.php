<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Price::class, static function (Faker $faker) {
    return [
        'customer_code' => $faker->word,
        'product' => $faker->word,
        'price' => $faker->randomFloat(),
        'break1' => $faker->randomNumber(),
        'price1' => $faker->randomFloat(),
        'break2' => $faker->randomNumber(),
        'price2' => $faker->randomFloat(),
        'break3' => $faker->randomNumber(),
        'price3' => $faker->randomFloat(),
    ];
});
