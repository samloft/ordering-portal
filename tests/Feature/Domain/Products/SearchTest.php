<?php

use App\Models\Price;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);

    $this->product = factory(Product::class)->create();
});

test('a product a customer can buy can be searched', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $this->followingRedirects()->get('/products/search', [
        'query' => $this->product->code,
    ])->assertStatus(200)->assertSee($this->product->description);
});

test('a product a customer cannot buy cannot be searched', function () {
    factory(Price::class)->create([
        'customer_code' => 'ABC123',
        'product' => $this->product->code,
    ]);

    $this->followingRedirects()->get('/products/search', [
        'query' => $this->product->code,
    ])->assertStatus(200)->assertDontSee($this->product->description)->assertSee('No products found');
});

test('a product that does not exist cannot be searched', function () {
    $this->followingRedirects()->get('/products/search', [
        'query' => $this->product->code,
    ])->assertStatus(200)->assertSee('No products found');
});
