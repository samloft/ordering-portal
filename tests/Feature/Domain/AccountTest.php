<?php

use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);
});

test('returns ok response', function () {
    $this->get(route('account'))->assertOk()->assertViewIs('account.index');
});

test('can be updated', function () {
    $this->post(route('account.store'), [
        'name' => 'Test User',
        'mobile' => '12345',
        'password' => null,
    ])->assertStatus(302)->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
    ]);
});

test('password is updated if passed', function () {
    $this->post(route('account.store'), [
        'name' => 'Test User',
        'mobile' => '12345',
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
    ])->assertStatus(302);

    $this->user->refresh();

    $this->assertTrue(Hash::check('newpassword', $this->user->password));
});
