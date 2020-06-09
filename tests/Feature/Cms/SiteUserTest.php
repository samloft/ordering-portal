<?php

use App\Models\Admin;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.site-users'))->assertOk();
});

test('can be created', function () {
    Mail::fake();

    $customer = factory(Customer::class)->create();

    $this->post(route('cms.site-users.store'), [
        'name' => 'Test User',
        'email' => 'example@example.com',
        'customer_code' => $customer->code,
    ])->assertCreated();

    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
    ]);
});

test('can be updated', function () {
    $customer = factory(Customer::class)->create();

    $user = factory(User::class)->create([
        'name' => 'Test User',
        'customer_code' => $customer->code,
    ]);

    $this->patch(route('cms.site-users.update', ['id' => $user->id]), [
        'name' => 'Updated',
        'email' => 'updated@example.com',
        'customer_code' => $customer->code,
    ])->assertOk();

    $this->assertDatabaseHas('users', [
        'name' => 'Updated',
    ]);
});

test('can be deleted', function () {
    $user = factory(User::class)->create();

    $this->delete(route('cms.site-users.destroy', ['id' => $user->id]))->assertOk();

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

test('can force password reset', function () {
    Mail::fake();

    $user = factory(User::class)->create();

    $this->post(route('cms.site-users.password-reset'), [
        'email' => $user->email,
    ])->assertOk();

    $this->assertDatabaseHas('password_resets', [
        'email' => $user->email,
    ]);
});

test('extra customer can be added', function () {
    $customer = factory(Customer::class)->create();

    $user = factory(User::class)->create([
        'name' => 'Test User',
        'customer_code' => $customer->code,
    ]);

    $extra_customer = factory(Customer::class)->create([
        'code' => 'ABC123',
    ]);

    $this->post(route('cms.extra-customers.store'), [
        'id' => $user->id,
        'code' => $extra_customer->code,
    ])->assertOk();

    $this->assertDatabaseHas('user_customers', [
        'user_id' => $user->id,
        'customer_code' => $extra_customer->code,
    ]);
});

test('extra customer can be deleted', function () {
    $customer = factory(Customer::class)->create();

    $user = factory(User::class)->create([
        'name' => 'Test User',
        'customer_code' => $customer->code,
    ]);

    $extra_customer = factory(Customer::class)->create([
        'code' => 'ABC123',
    ]);

    $this->post(route('cms.extra-customers.store'), [
        'id' => $user->id,
        'code' => $extra_customer->code,
    ])->assertOk();

    $this->delete(route('cms.extra-customers.destroy'), [
        'id' => 1,
    ]);

    $this->assertDatabaseMissing('user_customers', [
        'id' => 1,
    ]);
});
