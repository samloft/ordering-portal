<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\SavedBasket::class, static function (Faker $faker) {
    return [
        'customer_code' => $faker->word,
        'user_id' => $faker->randomNumber(),
        'reference' => $faker->word,
        'product' => $faker->word,
        'quantity' => $faker->randomNumber(),
        'created_at' => $faker->dateTime(),
    ];
});
