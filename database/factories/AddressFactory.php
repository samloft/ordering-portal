<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, static function (Faker $faker) {
    return [
        'customer_code' => 'SCO100',
        'user_id' => 1,
        'company_name' => $faker->company,
        'address_line_2' => $faker->streetAddress,
        'address_line_3' => $faker->secondaryAddress,
        'address_line_4' => $faker->city,
        'address_line_5' => $faker->state,
        'country' => $faker->country,
        'post_code' => $faker->postcode,
        'default' => 0,
    ];
});
