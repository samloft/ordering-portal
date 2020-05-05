<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\OrderLine::class, static function (Faker $faker) {
    return [
        'order_number' => $faker->word,
        'product' => $faker->word,
        'description' => $faker->text,
        'quantity' => $faker->randomNumber(),
        'stock_type' => $faker->word,
        'net_price' => $faker->randomFloat(),
        'total' => $faker->randomFloat(),
    ];
});
