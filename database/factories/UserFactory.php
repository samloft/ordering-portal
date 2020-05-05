<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\User::class, static function (Faker $faker) {
    return [
        'customer_code' => 'SCO100',
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'password_updated' => now(),
        'remember_token' => str_random(10),
        'name' => $faker->name,
        'admin' => false,
        'can_order' => true,
        'terms_accepted' => true,
    ];
});
