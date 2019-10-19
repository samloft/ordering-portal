<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Price;
use Faker\Generator as Faker;

$factory->define(Price::class, static function (Faker $faker) {
    return [
        'customer_code' => 'SCO100',
        'product' => $faker->randomNumber(8),
        'price' => $faker->randomFloat(2, 1, 100),
    ];
});
