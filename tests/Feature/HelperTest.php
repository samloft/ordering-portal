<?php

use Tests\Setup\UserFactory;

test('currency symbol is added on matching GBP code', function () {
    $user = (new UserFactory())->withCustomer([
        'currency' => 'GBP',
    ])->create();

    actingAs($user);

    $this->assertEquals('£1.2200', currency(1.2200));
});

test('currency symbol is added on matching EUR code', function () {
    $user = (new UserFactory())->withCustomer([
        'currency' => 'EUR',
    ])->create();

    actingAs($user);

    $this->assertEquals('€1.2200', currency(1.2200));
});

test('currency symbol is added on matching USD code', function () {
    $user = (new UserFactory())->withCustomer([
        'currency' => 'USD',
    ])->create();

    actingAs($user);

    $this->assertEquals('$1.2200', currency(1.2200));
});

test('currency symbol is added on matching AED code', function () {
    $user = (new UserFactory())->withCustomer([
        'currency' => 'AED',
    ])->create();

    actingAs($user);

    $this->assertEquals('DH 1.2200', currency(1.2200));
});

test('currency symbol is pounds as default', function () {
    $user = (new UserFactory())->withCustomer([
        'currency' => '',
    ])->create();

    actingAs($user);

    $this->assertEquals(currency(1.2200), '£1.2200');
});

test('currency symbol can be removed', function () {
    $this->assertEquals(removeCurrencySymbol('£1.2200'), 1.2200);
});

test('array values can be encoded', function () {
    $none_encoded = [
        'slash/',
    ];

    $this->assertEquals(encodeArrayValues($none_encoded), [
        'slash_',
    ]);
});
