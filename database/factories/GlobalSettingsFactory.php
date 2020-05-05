<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\GlobalSettings::class, static function (Faker $faker) {
    return [
        'key' => $faker->word,
        'value' => $faker->text,
    ];
});
