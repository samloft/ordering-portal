<?php

use App\Models\Admin;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.company-information'))->assertOk();
});

test('can be updated', function () {
    $this->post(route('cms.company-information.store', [
        'line_1' => 'new name',
    ]))->assertStatus(302)->assertSessionHas('success');

    $this->get(route('cms.company-information'))->assertSee('new name');
});
