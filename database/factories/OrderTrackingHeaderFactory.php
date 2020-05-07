<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\OrderTrackingHeader::class, static function (Faker $faker) {
    return [
        'order_number' => $faker->word,
        'base_order' => $faker->word,
        'reference' => $faker->word,
        'status' => $faker->word,
        'type' => $faker->word,
        'customer_code' => $faker->word,
        'invoice_customer' => $faker->word,
        'date_received' => $faker->date(),
        'date_required' => $faker->date(),
        'date_despatched' => $faker->date(),
        'date_invoiced' => $faker->date(),
        'invoice_no' => $faker->word,
        'delivery_address1' => $faker->word,
        'delivery_address2' => $faker->word,
        'delivery_address3' => $faker->word,
        'delivery_address4' => $faker->word,
        'delivery_address5' => $faker->word,
        'value' => $faker->randomFloat(),
        'invoice_address_1' => $faker->word,
        'invoice_address_2' => $faker->word,
        'invoice_address_3' => $faker->word,
        'invoice_address_4' => $faker->word,
        'consignment' => $faker->word,
        'vat' => $faker->randomFloat(),
        'small_order_charge' => $faker->randomFloat(),
        'delivery_method' => $faker->word,
        'delivery_cost' => $faker->randomFloat(),
    ];
});
