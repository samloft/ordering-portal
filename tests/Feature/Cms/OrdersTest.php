<?php

use App\Models\Admin;
use App\Models\OrderHeader;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.orders'))->assertOk();
});

test('can be marked to be re-imported', function () {
    $order = factory(OrderHeader::class)->create(
        ['imported' => true]
    );

    $this->get(route('cms.orders.import', ['order_number' => $order->order_number]))->assertRedirect();

    $this->assertDatabaseHas('order_header', [
        'imported' => false,
    ]);
});
