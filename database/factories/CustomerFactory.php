<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, static function (Faker $faker) {
    return [
        'code'                   => 'SCO100',
        'name'                   => $faker->name,
        'address_line_1'         => $faker->streetAddress,
        'address_line_2'         => $faker->streetAddress,
        'city'                   => $faker->city,
        'country'                => $faker->country,
        'post_code'              => $faker->postcode,
        'invoice_name'           => $faker->name,
        'invoice_address_line_1' => $faker->streetAddress,
        'invoice_address_line_2' => $faker->streetAddress,
        'invoice_city'           => $faker->city,
        'invoice_country'        => $faker->country,
        'invoice_postcode'       => $faker->postcode,
        'vat_flag'               => 'SS',
        'currency'               => 'GBP',
    ];
});
