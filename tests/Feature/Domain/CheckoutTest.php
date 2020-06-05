<?php

use App\Models\Basket;
use App\Models\DeliveryMethod;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\Setup\BasketFactory;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);

    $this->basket = (new BasketFactory())->create();

    $this->shipping = DeliveryMethod::create([
        'code' => 'TEST',
        'title' => 'Test delivery',
        'identifier' => 'Test delivery',
        'price' => 0,
        'price_low' => 0,
    ]);

    Storage::fake('ftp');
    Mail::fake();
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

    $this->post(route('checkout.order'), [
        'reference' => 'test',
        'name' => 'test',
        'shipping' => $this->shipping->id,
        'terms' => true,
    ])->assertStatus(302)->assertSessionHas('error');
});

test('mobile number is required if delivery address is not default', function () {
    Session::put('address', [
        'name' => 'test',
    ]);

    $this->followingRedirects()->from(route('checkout'))->post(route('checkout.order'), [
        'reference' => 'test',
        'name' => 'test',
        'shipping' => $this->shipping->id,
        'terms' => true,
    ])->assertSee('You must enter a mobile number');
});

test('terms needs to be accepted', function () {
    $this->followingRedirects()->from(route('checkout'))->post(route('checkout.order'), [
        'reference' => 'test',
        'name' => 'test',
        'shipping' => $this->shipping->id,
    ])->assertSee('terms must be accepted');
});

test('address session is removed on checkout completion', function () {
    Session::put('address', [
        'company_name' => 'New address',
        'address_line_2' => 'address 2',
        'address_line_3' => 'address 3',
        'address_line_4' => 'address 4',
        'post_code' => 'postcode',
    ]);

    $this->followingRedirects()->post(route('checkout.order'), [
        'reference' => 'test',
        'name' => 'test',
        'shipping' => $this->shipping->id,
        'terms' => true,
        'mobile' => '123456789',
    ])->assertOk()->assertSessionMissing('address');
});

test('completed page is displayed once order placed', function () {
    $this->followingRedirects()->from(route('checkout'))->post(route('checkout.order'), [
        'reference' => 'test',
        'name' => 'test',
        'shipping' => $this->shipping->id,
        'terms' => true,
    ])->assertSee('Completed');
});
