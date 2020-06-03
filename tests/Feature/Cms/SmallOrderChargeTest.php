<?php

use App\Models\Admin;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.small-order'))->assertOk();
});

test('can be updated', function () {
    $this->post(route('cms.small-order.update'), [
        'threshold' => 10,
        'charge' => 1,
        'exclude_delivery_charges' => false,
        'exclude_collection' => false,
    ])->assertRedirect()->assertSessionHas('success');
});
