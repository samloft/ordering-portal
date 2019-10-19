<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, static function (Faker $faker) {
    return [
        'code' => $faker->randomNumber(8),
        'type' => $faker->randomElement($array = ['P','B']),
        'name' => $faker->text(20),
        'uom' => 'EACH',
        'trade_price' => $faker->randomFloat(2, 1, 100),
        'order_multiples' => $faker->randomElement($array = [1, 5]),
        'description' => $faker->text(100),
        'not_sold' => false,
        'vat_flag' => 'S',
        'packaging' => 1
    ];
});
