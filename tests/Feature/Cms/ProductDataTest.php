<?php

use App\Models\Admin;
use App\Models\GlobalSettings;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.product-data'))->assertOk();
});

test('settings can be updated', function () {
    GlobalSettings::where('key', 'product-data')->update([
        'value' => json_encode([
            'data' => false,
            'prices' => false,
        ], JSON_THROW_ON_ERROR)
    ]);

    $this->patch(route('cms.product-data.update'), [
        'data' => true,
        'prices' => true,
    ])->assertRedirect()->assertSessionHas('success');
});
