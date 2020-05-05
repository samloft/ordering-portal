<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\OrderImport::class, static function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'customer_code' => $faker->word,
        'product' => $faker->word,
        'quantity' => $faker->randomNumber(),
    ];
});
