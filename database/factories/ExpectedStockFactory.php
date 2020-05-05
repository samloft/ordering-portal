<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ExpectedStock::class, static function (Faker $faker) {
    return [
        'product' => $faker->word,
        'quantity' => $faker->randomNumber(),
        'due_date' => $faker->dateTime(),
    ];
});
