<?php

use App\Models\Category;
use App\Models\CustomerDiscount;
use App\Models\ExpectedStock;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);

    $this->product = factory(Product::class)->create();
});

test('returns an ok response', function () {
    $this->get('products')->assertStatus(200);
});

test('can be viewed if allowed', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $this->get($this->product->path())->assertSee($this->product->description)->assertStatus(200);
});

test('cannot be viewed if not aloud', function () {
    $this->get($this->product->path())->assertStatus(200)->assertSee('not found')
        ->assertDontSee($this->product->description);
});

test('expected stock shows if data exists', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    factory(ExpectedStock::class)->create([
        'product' => $this->product->code,
    ]);

    $this->get($this->product->path())->assertSee('Expected Stock');
});

test('expected stock does not show if no data', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $this->get($this->product->path())->assertStatus(200)->assertDontSee('Expected Stock');
});

test('no discount is show if customer does not have one', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    factory(CustomerDiscount::class)->create([
        'customer_code' => $this->user->customer->code,
        'percent' => 0,
    ]);

    $this->get($this->product->path())->assertStatus(200)->assertDontSee('Discount');
});

test('discount is shown if customer has one', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    factory(CustomerDiscount::class)->create([
        'customer_code' => $this->user->customer->code,
        'percent' => 2,
    ]);

    $this->get($this->product->path())->assertStatus(200)->assertSee('Discount');
});

test('discount is removed from unit price', function () {
    factory(CustomerDiscount::class)->create([
        'customer_code' => $this->user->customer->code,
        'percent' => 2,
    ]);

    $product_price = factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $net_price = number_format($product_price->price * ((100 - 2) / 100), 4);

    $this->get($this->product->path())->assertSee('Discount')->assertSee($net_price);
});

test('bulk rates shown if they exist', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
        'price' => 100.00,
        'price1' => 10.00,
        'break1' => 100,
    ]);

    $this->get(route('products.show', ['product' => $this->product->code]))->assertSee('100')->assertSee('Discount %')
        ->assertSee('90.00%')->assertSee('Bulk Rates');
});

test('bulk rates dont show if none for customer', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
        'price' => 100.00,
        'price1' => 0,
        'break1' => 0,
        'price2' => 0,
        'break2' => 0,
        'price3' => 0,
        'break3' => 0,
    ]);

    $this->get($this->product->path())->assertStatus(200)->assertDontSee('Bulk Rates');
});

test('quantity is auto populated with order multiples value', function () {
    $product = factory(Product::class)->create([
        'order_multiples' => 123456,
    ]);

    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $product->code,
    ]);

    $this->get($product->path())->assertSee(123456);
});

test('image is returned if it exists', function () {
    Storage::fake();

    Storage::put($this->product->code.'.png', 'image');

    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $this->get($this->product->path())->assertSee($this->product->code.'.png');
});

test('image placeholder if no image found', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $this->get($this->product->path())->assertSee('no-image.png');
});

test('product list returns products for that category', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $categories = factory(Category::class)->create([
        'product' => $this->product->code,
        'level_1' => 'Test',
        'level_2' => null,
        'level_3' => null,
        'level_4' => null,
        'level_5' => null,
    ]);

    $this->get('products/'.$categories->level_1)->assertStatus(200)->assertSee($this->product->name);
});

test('passing false to product image returns blank', function () {
    $this->assertEquals($this->product->image(true), '');
});

test('can be auto completed', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $this->get(route('products.autocomplete', [
        'search' => substr($this->product->code, 0, 3),
    ]))->assertOk()->assertSee($this->product->code);
});
