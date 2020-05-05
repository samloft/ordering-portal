<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\OrderHeader::class, static function (Faker $faker) {
    return [
        'order_number' => $faker->word,
        'customer_code' => $faker->word,
        'user_id' => $faker->randomNumber(),
        'reference' => $faker->word,
        'notes' => $faker->word,
        'name' => $faker->name,
        'telephone' => $faker->word,
        'mobile' => $faker->word,
        'address_line_1' => $faker->word,
        'address_line_2' => $faker->word,
        'address_line_3' => $faker->word,
        'address_line_4' => $faker->word,
        'address_line_5' => $faker->word,
        'delivery_method' => $faker->word,
        'delivery_code' => $faker->word,
        'delivery_cost' => $faker->randomFloat(),
        'small_order_charge' => $faker->randomFloat(),
        'vat' => $faker->randomFloat(),
        'value' => $faker->randomFloat(),
        'promotion_discount' => $faker->randomFloat(),
        'imported' => $faker->boolean,
    ];
});
