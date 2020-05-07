<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Address::class, static function (Faker $faker) {
    return [
        'customer_code' => 'SCO100',
        'user_id' => $faker->randomNumber(),
        'company_name' => $faker->word,
        'address_line_2' => $faker->word,
        'address_line_3' => $faker->word,
        'address_line_4' => $faker->word,
        'address_line_5' => $faker->word,
        'country' => 'UK',
        'post_code' => $faker->word,
        'default' => $faker->randomNumber(),
    ];
});
