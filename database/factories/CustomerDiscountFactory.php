<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\CustomerDiscount::class, static function (Faker $faker) {
    return [
        'customer_code' => 'SCO100',
        'percent' => $faker->randomFloat(),
    ];
});
