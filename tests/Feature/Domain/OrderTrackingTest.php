<?php

use App\Models\Price;
use Tests\Setup\OrderTrackingFactory;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    $this->signIn($this->user);

    $this->orders = (new OrderTrackingFactory(10))->withLines()->create([
        'customer_code' => $this->user->customer->code,
    ]);
});

test('returns an ok response', function () {
    $this->get('order-tracking')->assertStatus(200);
});

test('can see past orders', function () {
    foreach ($this->orders as $order) {
        $this->get(route('order-tracking'))->assertSee($order->order_number);
    }
});

test('cannot see an order not placed by them', function () {
    $order = (new OrderTrackingFactory())->create([
        'order_number' => 'ABC123',
        'customer_code' => $this->user->customer->code.'TEST',
    ])->first();

    $this->get(route('order-tracking.show', ['order' => $order->order_number]))->assertStatus(404);
});

test('can search for an order', function () {
    $order = $this->orders->first();

    $this->get(route('order-tracking', ['keyword' => $order->order_number]))->assertSee($order->order_number)
        ->assertSee($order->reference)->assertSee($order->status);
});

test('can view a past order', function () {
    $order = $this->orders->first();

    $this->get(route('order-tracking.show', ['order' => $order->order_number]))->assertSee($order->order_number)
        ->assertSee($order->lines->first()->product);
});

test('can be copied to the basket', function () {
    $order = $this->orders->first();

    $this->get(route('order-tracking.copy-to-basket', ['order_number' => encodeUrl(trim($order->order_number))]));

    foreach ($order->lines as $order) {
        $this->assertDatabaseHas('basket', [
            'user_id' => $this->user->id,
            'customer_code' => $this->user->customer->code,
            'product' => $order->product,
            'quantity' => $order->quantity,
        ]);
    }
});

test('product that can no longer be purchased does not get copied to basket', function () {
    $order = $this->orders->first();

    $product = $order->lines->first()->product;

    Price::where('product', $product)->delete();

    $this->get(route('order-tracking.copy-to-basket', ['order_number' => encodeUrl(trim($order->order_number))]));

    $this->assertDatabaseMissing('basket', ['product' => $product]);
});

test('invoice pdf button does not display if not in archive', function () {
    $order = $this->orders->first();

    $this->get(route('order-tracking.show', ['order' => $order->order_number]))->assertDontSee('Download Copy Invoice');
});

test('invoice pdf can be download if exists in archive', function () {
    \Illuminate\Support\Facades\Http::fake([
        '*' => \Illuminate\Support\Facades\Http::response(\Illuminate\Http\UploadedFile::fake()->create('order.pdf'), 200),
    ]);

    $response = $this->get(route('order-tracking.invoice-pdf', [
        'order' => $this->orders->first()->order_number,
        'customer_order' => $this->orders->first()->reference,
        'download' => true,
    ]));
    //->assertOk();

    dd($response);

    $this->assertEquals($response->headers->get('content-type'), 'application/pdf');

    //Route::get('invoice/{order}/{customer_order}/{download?}', 'OrderTrackingController@invoicePdf')->name('order-tracking.invoice-pdf');
});

test('print order details returns pdf', function () {
    $order = $this->orders->first();

    $response = $this->get(route('order-tracking.pdf', ['order' => $order->order_number]));

    $response->assertStatus(200);
    $this->assertEquals($response->headers->get('content-type'), 'application/pdf');
});
