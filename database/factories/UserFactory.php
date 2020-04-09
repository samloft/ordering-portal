<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, static function (Faker $faker) {
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
