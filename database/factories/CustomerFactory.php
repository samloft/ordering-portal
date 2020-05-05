<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Customer::class, static function (Faker $faker) {
    return [
        'code' => 'SCO100',
        'name' => $faker->name,
        'address_line_1' => $faker->word,
        'address_line_2' => $faker->word,
        'city' => $faker->city,
        'country' => $faker->country,
        'post_code' => $faker->word,
        'invoice_name' => $faker->word,
        'invoice_address_line_1' => $faker->word,
        'invoice_address_line_2' => $faker->word,
        'invoice_city' => $faker->word,
        'invoice_country' => $faker->word,
        'invoice_postcode' => $faker->word,
        'vat_flag' => $faker->word,
        'currency' => $faker->word,
        'buying_group' => $faker->word,
        'price_list' => $faker->word,
        'discount_code' => $faker->word,
    ];
});
