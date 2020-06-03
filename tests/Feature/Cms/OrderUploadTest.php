<?php

use App\Models\Admin;
use App\Models\GlobalSettings;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.order-upload'))->assertOk();
});

test('settings can be updated', function () {
    GlobalSettings::where('key', 'upload-config')->update([
        'key' => json_encode([
            'packs' => true,
            'prices' => true,
        ], JSON_THROW_ON_ERROR | true),
    ]);

    $this->post(route('cms.order-upload.store'), [
        'prices' => false,
        'packs' => false,
    ])->assertRedirect()->assertSessionHas('success');
});
