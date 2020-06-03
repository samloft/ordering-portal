<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.admin-users'))->assertOk();
});

test('can be deleted', function () {
    $admin = factory(Admin::class)->create();

    $this->delete(route('cms.admin-users.destroy', ['id' => $admin->id]))->assertOk();

    $this->assertDeleted($admin);
});

test('can be created', function() {
    Mail::fake();

    $this->post(route('cms.admin-users.store'), [
        'name' => 'Example user',
        'email' => 'example@example.com',
    ])->assertCreated();
});

test('can be updated', function () {
    $admin = factory(Admin::class)->create();

    $this->patch(route('cms.admin-users.update', ['id' => $admin->id]), [
        'name' => 'New name',
    ])->assertOk();

    $this->assertDatabaseHas('cms_users', [
        'name' => 'New name',
    ]);
});
