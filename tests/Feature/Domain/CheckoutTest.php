<?php

use App\Models\Basket;
use Tests\Setup\BasketFactory;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);

    $this->basket = (new BasketFactory())->create();
});

test('returns an ok response', function () {
    $this->get(route('checkout'))->assertOk();
});

test('redirected to basket if basket is empty', function () {
    Basket::where('customer_code', $this->user->customer->code)->where('user_id', $this->user->id)->delete();

    $this->get(route('checkout'))->assertStatus(302)->assertSessionHas('error');
});

test('user that cannot order cannot checkout', function () {
    $cannot_order_user = (new UserFactory())->withCustomer(['code' => 'ABC123'])->create([
        'can_order' => false,
    ]);

    actingAs($cannot_order_user);

    factory(Basket::class)->create([
        'customer_code' => $cannot_order_user->customer->code,
        'user_id' => $cannot_order_user->id,
        'product' => $this->basket->first()->code,
        'quantity' => 10,
    ]);

    $this->get(route('checkout'))->assertStatus(302)->assertSessionHas('error');
});
