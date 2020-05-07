<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Promotion::class, static function (Faker $faker) {
    return [
        'type' => $faker->word,
        'product' => $faker->word,
        'product_qty' => $faker->randomNumber(),
        'value_reward' => $faker->word,
        'promotion_product' => $faker->word,
        'promotion_qty' => $faker->randomNumber(),
        'minimum_value' => $faker->randomFloat(),
        'value_percent' => $faker->randomFloat(),
        'claim_type' => $faker->word,
        'max_claims' => $faker->randomNumber(),
        'restrictions' => $faker->word,
        'buying_groups' => $faker->text,
        'price_lists' => $faker->text,
        'discount_codes' => $faker->text,
        'start_date' => $faker->date(),
        'end_date' => $faker->date(),
    ];
});
