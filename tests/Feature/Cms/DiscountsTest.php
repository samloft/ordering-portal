<?php

use App\Models\Admin;
use App\Models\Customer;
use App\Models\CustomerDiscount;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.discounts'))->assertOk();
});

test('global discount can be set', function () {
    $this->post(route('cms.discounts.global-store', [
        'global_discount' => 5,
    ]))->assertRedirect()->assertSessionHas('success');

    $this->get(route('cms.discounts'))->assertSee(5);
});

test('customer override can be created', function () {
    $customer = factory(Customer::class)->create();

    $this->post(route('cms.discounts.customer-store', [
        'customer_code' => $customer->code,
        'percent' => 2,
    ]))->assertOk();

    $this->assertDatabaseHas('customer_discounts', [
        'customer_code' => $customer->code,
        'percent' => 2,
    ]);
});

test('customer override cannot be created if customer does not exist', function () {
    $this->post(route('cms.discounts.customer-store', [
        'customer_code' => 'ABC123',
        'percent' => 2,
    ]))->assertSessionHasErrors('customer_code');
});

test('customer override can be updated', function () {
    $customer = factory(Customer::class)->create();

    $override = factory(CustomerDiscount::class)->create([
        'customer_code' => $customer->code,
        'percent' => 1,
    ]);

    $this->post(route('cms.discounts.customer-store', [
        'id' => $override->id,
        'percent' => 5,
    ]))->assertOk();

    $this->assertDatabaseHas('customer_discounts', [
        'id' => $override->id,
        'percent' => 5,
    ]);
});

test('customer override can be deleted', function () {
    $override = factory(CustomerDiscount::class)->create();

    $this->delete(route('cms.discounts.customer-destroy', [
        'id' => $override->id,
    ]))->assertOk();

    $this->assertDatabaseMissing('customer_discounts', [
        'id' => $override->id,
    ]);
});
