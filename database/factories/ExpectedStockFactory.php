<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ExpectedStock;
use Faker\Generator as Faker;

$factory->define(ExpectedStock::class, static function (Faker $faker) {
    return [
        'product' => $faker->randomNumber(8),
        'quantity' => $faker->numberBetween(0, 3000),
        'due_date' => $faker->date() . ' ' . $faker->time()
    ];
});
