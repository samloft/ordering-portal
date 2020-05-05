<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderTrackingLine;
use Faker\Generator as Faker;

$factory->define(OrderTrackingLine::class, static function (Faker $faker) {
    return [
        'order_number' => $faker->randomNumber(8),
        'order_line_no' => $faker->randomNumber(4),
        'product' => $faker->randomNumber(8),
        'description' => $faker->name,
        'quantity' => $quantity = $faker->randomNumber(4),
        'net_price' => $price = $faker->randomFloat(4, 2, 100),
        'total' => $quantity * $price,
    ];
});
