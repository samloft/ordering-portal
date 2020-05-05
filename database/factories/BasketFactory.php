<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Basket;
use Faker\Generator as Faker;

$factory->define(Basket::class, static function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'customer_code' => $faker->word,
        'product' => $faker->randomNumber(8),
        'quantity' => $faker->randomNumber(2),
    ];
});
