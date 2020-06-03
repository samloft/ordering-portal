<?php

use App\Models\Admin;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.site-settings'))->assertOk();
});

test('maintenance mode can be enabled', function () {
    $this->patch(route('cms.site-settings.maintenance'), [
        'enabled' => true,
        'message' => 'test maintenance',
    ])->assertOk();
});

test('can be updated', function () {
    $this->patch(route('cms.site-settings.update'), [
        'announcement' => 'test',
        'default_country' => 'UK',
        'last_order' => 'Z000001',
    ])->assertRedirect()->assertSessionHas('success');
});
