<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\UserCustomer::class, static function (Faker $faker) {
    return [
        'user_id' => 'SCO100',
        'customer_code' => $faker->word,
    ];
});
