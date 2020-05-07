<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Contact::class, static function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
    ];
});
