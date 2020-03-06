<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\UserCustomer;
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

$factory->define(UserCustomer::class, static function (Faker $faker) {
    return [
        'customer_code' => 'SCO100',
        'user_id'       => 1,
        'created_at'    => date('Y-m-d H:i:s'),
        'updated_at'    => date('Y-m-d H:i:s'),
    ];
});
