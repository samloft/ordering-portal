<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\CustomerFactory;
use Tests\Setup\UserFactory;

uses(RefreshDatabase::class);

test('user with no additional customers cannot see change customer dropdown', function () {
    $user = (new UserFactory())->withCustomer()->create();

    actingAs($user);

    $this->get('products')->assertDontSee('Change Customer');
});

test('user with additional customers can see change customer dropdown', function () {
    $user = (new UserFactory())->withCustomer()->withUserCustomers(2)->create();

    actingAs($user);

    $customers = [];

    foreach ($user->customers as $customer) {
        $customers[] = $customer->code;
    }

    $this->get('products')->assertSee('Change Customer')->assertSee($customers);
});

test('user with additional customers can switch to another customer', function () {
    $user = (new UserFactory())->withCustomer()->withUserCustomers(2)->create();

    actingAs($user);

    $this->followingRedirects()->post('account/customer/change', ['customer' => $user->customers->first()->code])
        ->assertSee('You are currently assuming the customer code')->assertSee($user->customers->first()->code)
        ->assertSame($user->customer->code, $user->customers->first()->code);
});

test('admin can see change customer input', function() {
    $admin = (new UserFactory)->withCustomer()->create([
        'admin' => true,
    ]);

    actingAs($admin);

    $this->get('products')->assertSee('CHANGE CUSTOMER');
});

test('admin can switch to any customer', function () {
    $admin = (new UserFactory)->withCustomer()->create([
        'admin' => true,
    ]);

    actingAs($admin);

    $customer = (new CustomerFactory())->create()->first();

    $this->followingRedirects()->post('account/customer/change', ['customer' => $customer->code])
        ->assertSee('You are currently assuming the customer code')->assertSee($customer->code)
        ->assertSame($admin->customer->code, $customer->code);
});

test('customer can be reverted to the default customer', function() {
    $user = (new UserFactory())->withCustomer()->withUserCustomers(2)->create();

    actingAs($user);

    $this->followingRedirects()->post('account/customer/change', ['customer' => $user->customers->first()->code])
        ->assertSame($user->customer->code, $user->customers->first()->code);

    $this->followingRedirects()->get('account/customer/revert')->assertNotSame($user->customer->code, $user->customers->first()->code);
});
