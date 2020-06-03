<?php

use App\Models\Admin;
use App\Models\DeliveryMethod;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.delivery-methods'))->assertOk();
});

test('can be created', function () {
    $delivery_method = [
        'code' => 'A123',
        'title' => 'Delivery',
        'identifier' => 'DELIVERY',
        'price' => 10,
        'price_low' => 5,
    ];

    $this->post(route('cms.delivery-methods.store', $delivery_method))->assertOk();

    $this->assertDatabaseHas('delivery_methods', $delivery_method);
});

test('can be updated', function () {
    $delivery_method = factory(DeliveryMethod::class)->create([
        'code' => 'A123',
    ]);

    $this->post(route('cms.delivery-methods.store', [
        'id' => $delivery_method->id,
        'code' => 'B123',
        'title' => 'Delivery',
        'identifier' => 'DELIVERY',
        'price' => 10,
        'price_low' => 5,
    ]))->assertOk();

    $this->assertDatabaseMissing('delivery_methods', [
        'code' => 'A123',
    ]);

    $this->assertDatabaseHas('delivery_methods', [
        'code' => 'B123',
    ]);
});

test('can be deleted', function () {
    $delivery_method = factory(DeliveryMethod::class)->create();

    $this->delete(route('cms.delivery-methods.delete', ['deliveryMethod' => $delivery_method->id]))->assertOk();

    $this->assertDatabaseMissing('delivery_methods', [
        'code' => $delivery_method->code,
    ]);
});

test('default collection message can be added', function () {
    $collection_message = [
        'times' => [
            [
                'start' => '00:00:00',
                'end' => '11:00:00',
                'message' => 'timed message',
                'identifier' => 'timed message',
            ],
        ],
        'default' => 'default_message',
    ];

    $this->post(route('cms.collection-messages.store', $collection_message))->assertOk();
});
