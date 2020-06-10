<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.site-settings'))->assertOk();
});

test('maintenance mode can be enabled', function () {
    Storage::fake();

    $this->patch(route('cms.site-settings.maintenance'), [
        'enabled' => true,
        'message' => 'test maintenance',
    ])->assertOk();
});

test('CMS can still be accessed when maintenance mode is enabled', function () {
    Storage::fake();

    $this->from(route('cms.site-settings.maintenance'))->patch(route('cms.site-settings.maintenance'), [
        'enabled' => true,
        'message' => 'test maintenance',
    ])->assertOk();

    $this->followingRedirects()->get(route('cms.index'));

    $this->get('/cms')->assertOk()->assertSee('Dashboard');
});

test('main site cannot be accessed when maintenance mode is enabled', function () {
    Storage::fake();

    $this->patch(route('cms.site-settings.maintenance'), [
        'enabled' => true,
        'message' => 'test maintenance',
    ])->assertOk();

    $this->followingRedirects()->get('/')->assertStatus(503)->assertSee('test maintenance');
});

test('can be updated', function () {
    $this->patch(route('cms.site-settings.update'), [
        'announcement' => 'test',
        'default_country' => 'UK',
        'last_order' => 'Z000001',
    ])->assertRedirect()->assertSessionHas('success');
});
