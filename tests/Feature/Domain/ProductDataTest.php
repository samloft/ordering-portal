<?php

use App\Models\GlobalSettings;
use Tests\Setup\ProductFactory;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);
});

test('returns an ok response', function () {
    $this->get(route('product-data'))->assertOK();
});

test('returns 404 if no data is enabled', function () {
    GlobalSettings::where('key', 'product-data')->update([
        'value' => json_encode([
            'data' => false,
            'prices' => false,
        ], JSON_THROW_ON_ERROR | true),
    ]);

    $this->get(route('product-data'))->assertStatus(404);
});

test('data returns excel', function () {
    (new ProductFactory())->withPrices($this->user->customer->code)->create();

    $response = $this->get(route('product-data.data'));

    $response->assertStatus(200);
    $this->assertEquals($response->headers->get('content-type'), 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
});

test('prices returns excel', function () {
    (new ProductFactory())->withPrices($this->user->customer->code)->create();

    $response = $this->get(route('product-data.prices'));

    $response->assertStatus(200);
    $this->assertEquals($response->headers->get('content-type'), 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
});
