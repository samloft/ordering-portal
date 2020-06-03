<?php

use App\Models\Admin;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('accessibility returns an ok response', function () {
    $this->get(route('cms.pages.accessibility'))->assertOk();
});

test('data protection returns an ok response', function () {
    $this->get(route('cms.pages.data-protection'))->assertOk();
});

test('terms returns an ok response', function () {
    $this->get(route('cms.pages.terms'))->assertOk();
});

test('can be updated', function () {
    $this->post(route('cms.pages.store'), [
        'name' => 'terms-and-conditions',
        'description' => 'Updated',
    ])->assertRedirect()->assertSessionHas('success');

    $this->assertDatabaseHas('pages', [
        'description' => 'Updated',
    ]);
});
