<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Activity::class, static function (Faker $faker) {
    return [
        'log_name' => $faker->word,
        'description' => $faker->text,
        'subject_id' => $faker->randomNumber(),
        'subject_type' => $faker->word,
        'causer_id' => $faker->randomNumber(),
        'causer_type' => $faker->word,
        'properties' => $faker->text,
    ];
});
