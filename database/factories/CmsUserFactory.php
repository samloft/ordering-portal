<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CmsUser;
use Faker\Generator as Faker;

$factory->define(CmsUser::class, static function (Faker $faker) {
    return [
        'name'     => $faker->name,
        'email'    => 'example@example.com',
        'password' => bcrypt('password'),
    ];
});
