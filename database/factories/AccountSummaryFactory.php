<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\AccountSummary::class, static function (Faker $faker) {
    return [
        'customer_code' => $faker->word,
        'item_no' => $faker->word,
        'reference' => $faker->word,
        'dated' => $faker->date(),
        'due_date' => $faker->date(),
        'unall_curr_amount' => $faker->randomFloat(),
        'age' => $faker->word,
    ];
});
