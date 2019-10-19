<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Stock;
use Faker\Generator as Faker;

$factory->define(Stock::class, static function (Faker $faker) {
    return [
        'product' => $faker->randomNumber(8),
        'quantity' => $faker->numberBetween(0, 3000)
    ];
});
