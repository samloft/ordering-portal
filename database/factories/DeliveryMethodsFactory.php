<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DeliveryMethod;
use Faker\Generator as Faker;

$factory->define(DeliveryMethod::class, static function (Faker $faker) {
    return [
        'code' => strtoupper($faker->bothify('?####')),
        'title' => $name = $faker->name(),
        'identifier' => strtoupper($name),
        'price' => $faker->numberBetween(11, 15),
        'price_low' => $faker->numberBetween(1, 10),
    ];
});
