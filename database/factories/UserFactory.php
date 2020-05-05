<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, static function (Faker $faker) {
    return [
        'customer_code' => $faker->word,
        'email' => $faker->safeEmail,
        'password' => bcrypt($faker->password),
        'password_updated' => $faker->dateTime(),
        'remember_token' => Str::random(10),
        'name' => $faker->name,
        'telephone' => $faker->word,
        'mobile' => $faker->word,
        'admin' => $faker->boolean,
        'can_order' => $faker->boolean,
        'api_token' => $faker->word,
        'terms_accepted' => $faker->boolean,
    ];
});
