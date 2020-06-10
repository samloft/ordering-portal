<?php

use Tests\Setup\CustomerFactory;
use Tests\Setup\UserFactory;

test('no additional customers cannot see change customer dropdown', function () {
    $user = (new UserFactory())->withCustomer()->create();

    actingAs($user);

    $this->get('products')->assertDontSee('Change Customer');
});

test('additional customers can see change customer dropdown', function () {
    $user = (new UserFactory())->withCustomer()->withUserCustomers(2)->create();

    actingAs($user);

    $this->get('products')->assertSee('Change Customer');
});

test('additional customers can switch to another customer', function () {
    $user = (new UserFactory())->withCustomer()->withUserCustomers(2)->create();

    actingAs($user);

    $this->followingRedirects()
        ->post('account/customer/change', ['customer' => $user->customers->first()->customer_code])
        ->assertSee('You are currently assuming the customer code')
        ->assertSee($user->customers->first()->customer_code);
});

test('admin can see change customer input', function () {
    $admin = (new UserFactory)->withCustomer()->create([
        'admin' => true,
    ]);

    actingAs($admin);

    $this->get('products')->assertSee('Change Customer');
});

test('admin can switch to any customer', function () {
    $admin = (new UserFactory)->withCustomer()->create([
        'admin' => 1,
    ]);

    actingAs($admin);

    $customer = (new CustomerFactory(1))->create(['code' => 'NEWCUST'])->first();

    $this->followingRedirects()->post('account/customer/change', ['customer' => $customer->code])
        ->assertSee('You are currently assuming the customer code')->assertSee($customer->code);
});

test('changing to default reverts the change', function () {
    $user = (new UserFactory())->withCustomer()->withUserCustomers(2)->create();

    actingAs($user);

    $this->post('account/customer/change', ['customer' => $user->customer_code])->assertRedirect(route('home'))
        ->assertSessionHas('temp_customer', '')->assertDontSee('You are currently assuming the customer code');
});

test('cannot switch to customer with no access', function () {
    $user = (new UserFactory())->withCustomer()->withUserCustomers(2)->create();

    actingAs($user);

    $this->post('account/customer/change', ['customer' => 'ABC123'])->assertStatus(401);
});

test('admins cannot switch to a customer that no longer exist', function () {
    $admin = (new UserFactory())->withCustomer()->create([
        'admin' => 1,
    ]);

    actingAs($admin);

    $this->post('/account/customer/change', ['customer', 'ABC123'])->assertStatus(302)->assertSessionHas('error');
});

test('is auto completed', function () {
    $user = (new UserFactory())->withCustomer()->withUserCustomers(2)->create([
        'admin' => 1,
    ]);

    actingAs($user);

    $this->post(route('customer.autocomplete', ['customer' => substr($user->customers->first()->code, 0, 3)]))
        ->assertOk()->assertSee($user->customers->first()->code);
});
