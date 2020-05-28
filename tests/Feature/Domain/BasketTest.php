<?php

use App\Models\Basket;
use App\Models\Price;
use App\Models\Product;
use Tests\Setup\BasketFactory;
use Tests\Setup\ProductFactory;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);

    $this->product = factory(Product::class)->create([
        'order_multiples' => 10,
    ]);
});

test('returns an ok response', function () {
    $this->get('basket')->assertStatus(200);
});

test('can buy a product they can purchase', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $this->post('basket/add-product', [
        'product' => $this->product->code,
        'quantity' => 10,
        'update' => false,
    ]);

    $this->assertDatabaseHas('basket', [
        'user_id' => $this->user->id,
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
        'quantity' => 10,
    ]);
});

test('cannot buy a product they cannot purchase', function () {
    factory(Price::class)->create([
        'customer_code' => 'ABC123',
        'product' => $this->product->code,
    ]);

    $this->post('basket/add-product', [
        'product' => $this->product->code,
        'quantity' => 10,
        'update' => false,
    ])->assertStatus(422)->assertSee('The product you have entered does not exist');

    $this->assertDatabaseMissing('basket', [
        'product' => $this->product->code,
    ]);
});

test('quantity gets auto incremented to selling order multiples', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $this->post('basket/add-product', [
        'product' => $this->product->code,
        'quantity' => 5,
        'update' => false,
    ])->assertStatus(200)->assertSee('Increased from 5 to 10');

    $this->assertDatabaseHas('basket', [
        'user_id' => $this->user->id,
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
        'quantity' => 10,
    ]);
});

test('can buy a product that is obsolete with stock', function () {
    $product = (new ProductFactory())->withPrices($this->user->customer->code)->create([
        'obsolete' => true,
        'stock' => 100,
    ])->first();

    $this->post('basket/add-product', [
        'product' => $product->code,
        'quantity' => 10,
        'update' => false,
    ]);

    $this->assertDatabaseHas('basket', [
        'user_id' => $this->user->id,
        'customer_code' => $this->user->customer->code,
        'product' => $product->code,
        'quantity' => 10,
    ]);
});

test('cannot buy a product that is obsolete with no stock', function () {
    $product = (new ProductFactory())->withPrices($this->user->customer->code)->create([
        'obsolete' => 1,
        'stock' => 0,
    ])->first();

    $this->post('basket/add-product', [
        'product' => $product->code,
        'quantity' => 10,
        'update' => false,
    ])->assertStatus(422);

    $this->assertDatabaseMissing('basket', [
        'product' => $product->code,
    ]);
});

test('obsolete product has order quantity reduced if over stock level', function () {
    $product = (new ProductFactory())->withPrices($this->user->customer->code)->create([
        'obsolete' => 1,
        'stock' => 100,
    ])->first();

    $this->post('basket/add-product', [
        'product' => $product->code,
        'quantity' => 200,
        'update' => false,
    ]);

    $this->assertDatabaseHas('basket', [
        'product' => $product->code,
        'quantity' => 100,
    ]);
});

test('product line can be removed', function () {
    $product = (new ProductFactory())->withPrices($this->user->customer->code)->create([
        'order_multiples' => 1,
    ])->first();

    $this->post('basket/add-product', [
        'product' => $product->code,
        'quantity' => 10,
        'update' => false,
    ])->assertStatus(200);

    $this->assertDatabaseHas('basket', [
        'product' => $product->code,
    ]);

    $this->post('basket/delete-product', ['product' => $product->code]);

    $this->assertDatabaseMissing('basket', [
        'product' => $product->code,
    ]);
});

test('product line can have the quantity updated', function () {
    $product = (new ProductFactory())->withPrices($this->user->customer->code)->create([
        'order_multiples' => 1,
    ])->first();

    $this->post('basket/add-product', [
        'product' => $product->code,
        'quantity' => 10,
        'update' => false,
    ])->assertStatus(200);

    $this->assertDatabaseHas('basket', [
        'product' => $product->code,
    ]);

    $this->post('basket/add-product', [
        'product' => $product->code,
        'quantity' => 20,
        'update' => true,
    ])->assertStatus(200);

    $this->assertDatabaseMissing('basket', [
        'product' => $product->code,
        'quantity' => 10,
    ]);

    $this->assertDatabaseHas('basket', [
        'product' => $product->code,
        'quantity' => 20,
    ]);
});

test('basket can be cleared', function () {
    $products = (new ProductFactory())->withPrices($this->user->customer->code)->create();

    foreach ($products as $product) {
        $this->post('basket/add-product', [
            'product' => $product->code,
            'quantity' => 10,
            'update' => false,
        ])->assertStatus(200);
    }

    $this->assertDatabaseHas('basket', [
        'customer_code' => $this->user->customer->code,
    ]);

    $this->followingRedirects()->get('basket/empty')->assertStatus(200);

    $this->assertDatabaseMissing('basket', [
        'customer_code' => $this->user->customer->code,
    ]);
});

test('bulk rate savings are displayed if within 75%', function () {
    $product = (new BasketFactory())->create()->first();

    Price::where('customer_code', $this->user->customer->code)->where('product', $product->code)->update([
        'price' => 10.00,
        'price1' => 5.00,
        'break1' => 500,
    ]);

    Basket::where('user_id', $this->user->id)->where('product', $product->code)->update([
        'quantity' => 450,
    ]);

    $this->get(route('basket'))->assertSee('"potential_saving":true');
});
