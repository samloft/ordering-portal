<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Price::class, static function (Faker $faker) {
    return [
        'customer_code' => 'SCO100',
        'product' => $faker->randomNumber(8),
        'price' => $faker->randomFloat(2, 1, 100),
        'break1' => null,
        'price1' => null,
        'break2' => null,
        'price2' => null,
        'break3' => null,
        'price3' => null,
    ];
});
