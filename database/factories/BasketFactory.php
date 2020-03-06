<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Basket;
use Faker\Generator as Faker;

$factory->define(Basket::class, static function (Faker $faker) {
    return [
        'user_id' => 1,
        'customer_code' => 'SCO100',
        'product' => $faker->randomNumber(8),
        'quantity' => $faker->randomNumber(2),
    ];
});
