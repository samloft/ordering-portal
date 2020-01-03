<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderTrackingHeader;
use Faker\Generator as Faker;

$factory->define(OrderTrackingHeader::class, static function (Faker $faker) {
    return [
        'order_no'          => $order = $faker->randomNumber(8),
        'base_order'        => $order,
        'customer_order_no' => $faker->text(10),
        'status'            => $faker->randomElement([
            'Cancelled',
            'Despatched',
            'In Progress',
            'Invoiced',
        ]),
        'type'              => 'Invoice',
        'customer_code'     => 'SCO100',
        'invoice_customer'  => 'SCO100',
        'date_received'     => $faker->dateTime,
        'date_despatched'   => $faker->dateTime,
        'date_invoiced'     => $faker->dateTime,
        'invoice_no'        => $faker->randomNumber(8),
        'delivery_address1' => $faker->streetAddress,
        'delivery_address2' => $faker->streetName,
        'delivery_address3' => $faker->country,
        'delivery_address4' => $faker->city,
        'delivery_address5' => $faker->postcode,
        'value'             => $value = $faker->randomFloat(2, 10, 100),
        'invoice_address_1' => $faker->streetAddress,
        'invoice_address_2' => $faker->country,
        'invoice_address_3' => $faker->city,
        'invoice_address_4' => $faker->postcode,
        'vat_value'         => (20 / 100) * $value,
        'consignment'       => '',
        'delivery_service'  => $faker->randomElement([
            'Collection',
            'Next Day',
            'Next day timed',
            'Standard Delivery',
        ]),
    ];
});
