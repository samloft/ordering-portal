<?php

use Faker\Generator as Faker;
use App\Models\User;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'customer_code' => 'SCO100',
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'password_updated' => now(),
        'remember_token' => str_random(10),
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'admin' => false,
        'cms_admin' => false,
        'discount' => 0,
        'country_id' => 1,
        'can_order' => 1
    ];
});
