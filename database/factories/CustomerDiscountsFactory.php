<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CustomerDiscount;
use Faker\Generator as Faker;

$factory->define(CustomerDiscount::class, static function (Faker $faker) {
    return [
        'customer_code' => $faker->randomNumber(8),
        'percent' => $faker->randomFloat(2, 1, 10),
    ];
});
