<?php

use App\Models\GlobalSettings;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Tests\Setup\ProductFactory;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    $this->signIn($this->user);

    $this->products = (new ProductFactory())->withPrices($this->user->customer->code)->create();
});

test('returns a valid response', function () {
    $this->get('upload')->assertStatus(200);
});

test('price tolerance is displayed if enabled', function () {
    GlobalSettings::where('key', 'upload-config')->update([
        'value' => json_encode([
            'prices' => true,
            'packs' => false,
        ], JSON_THROW_ON_ERROR | true),
    ]);

    $this->get('upload')->assertSee('Price Tolerance');
});

test('packs option is displayed if enabled', function () {
    GlobalSettings::where('key', 'upload-config')->update([
        'value' => json_encode([
            'prices' => false,
            'packs' => true,
        ], JSON_THROW_ON_ERROR | true),
    ]);

    $this->get('upload')->assertSee('Order in pack');
});

test('options are not displayed if both disabled', function () {
    GlobalSettings::where('key', 'upload-config')->update([
        'value' => json_encode([
            'prices' => false,
            'packs' => false,
        ], JSON_THROW_ON_ERROR | true),
    ]);

    $this->get('upload')->assertDontSee('Order in pack')->assertDontSee('Price Tolerance');
});

test('csv file is required', function () {
    $this->post(route('upload-validate'), [
        'csv_file' => UploadedFile::fake()->createwithContent('test.xlsx', $this->products->first().', 200'),
    ])->assertSessionHasErrors('csv_file');

    $this->post(route('upload-validate'), [
        'csv_file' => null,
    ])->assertSessionHasErrors('csv_file');

    $this->post(route('upload-validate'), [
        'csv_file' => UploadedFile::fake()->createwithContent('test.csv', $this->products->first().', 200')
            ->mimeType('text/csv'),
    ])->assertSessionDoesntHaveErrors('csv_file')->assertStatus(302);
});

test('blank csv returns error', function () {
    $this->post(route('upload-validate'), [
        'csv_file' => UploadedFile::fake()->createwithContent('test.csv', '')->mimeType('text/csv'),
    ])->assertSessionHas('error');
});

test('duplicate product codes get merged', function () {
    $order = [];

    foreach ($this->products as $product) {
        $order[] = $product->code.', 100';
    }

    $order[] = $this->products->first()->code.',200';

    $this->followingRedirects()->post(route('upload-validate'), [
        'csv_file' => UploadedFile::fake()->createwithContent('test.csv', implode("\n", $order))->mimeType('text/csv'),
    ]);

    $this->assertDatabaseHas('order_imports', [
        'product' => $this->products->first()->code,
        'quantity' => 300,
    ]);
});

test('upload with prices gets matched', function () {
    $order = [];

    foreach ($this->products as $product) {
        $order[] = $product->code.',100,'.$product->prices->price;
    }

    $this->followingRedirects()->post(route('upload-validate'), [
        'csv_file' => UploadedFile::fake()->createwithContent('test.csv', implode("\n", $order))->mimeType('text/csv'),
    ])->assertSee('Passed Price')->assertSee('Actual Price');
});

test('quantities get converted to packs if selected', function () {
    GlobalSettings::where('key', 'upload-config')->update([
        'value' => json_encode([
            'prices' => false,
            'packs' => true,
        ], JSON_THROW_ON_ERROR | true),
    ]);

    $product = $this->products->first();

    Product::where('code', $product->code)->update([
        'order_multiples' => 1,
        'packaging' => 100,
    ]);

    $product = Product::where('code', $product->code)->firstOrFail();

    $this->followingRedirects()->post(route('upload-validate'), [
        'packs' => 'on',
        'csv_file' => UploadedFile::fake()->createwithContent('test.csv', $product->code.',100')->mimeType('text/csv'),
    ]);

    $this->assertDatabaseHas('order_imports', [
        'product' => $product->code,
        'quantity' => 1,
    ]);
});

test('upload can be added to the basket', function () {
    $order = [];

    foreach ($this->products as $product) {
        $order[] = $product->code.',100,'.$product->prices->price;
    }

    $this->followingRedirects()->post(route('upload-validate'), [
        'csv_file' => UploadedFile::fake()->createwithContent('test.csv', implode("\n", $order))->mimeType('text/csv'),
    ]);

    $this->followingRedirects()->get(route('upload-completed'))->assertViewIs('upload.completed')
        ->assertSee('Completed');

    $this->assertDatabaseHas('basket', [
        'user_id' => $this->user->id,
        'customer_code' => $this->user->customer->code,
        'product' => $this->products->first()->code,
        'quantity' => 100,
    ]);
});

test('quantities get incremented based on order multiples', function () {
    $product = $this->products->first();

    Product::where('code', $product->code)->update(['order_multiples' => 10]);

    $product = Product::where('code', $product->code)->firstOrFail();

    $this->followingRedirects()->post(route('upload-validate'), [
        'csv_file' => UploadedFile::fake()->createwithContent('test.csv', $product->code.',12')->mimeType('text/csv'),
    ])->assertSee('Quantity not in multiples')->assertSee('10')->assertSee('20');

    $this->assertDatabaseHas('order_imports', [
        'product' => $product->code,
        'quantity' => 20,
    ]);
});

test('not sold products are treated as not existing', function () {
    $product = $this->products->first();

    Product::where('code', $product->code)->update(['not_sold' => 'Y']);

    $product = Product::where('code', $product->code)->firstOrFail();

    $this->followingRedirects()->post(route('upload-validate'), [
        'csv_file' => UploadedFile::fake()->createwithContent('test.csv', $product->code.',12')->mimeType('text/csv'),
    ])->assertSee('Product not found')->assertSee('10')->assertSee('20');

    $this->assertDatabaseMissing('order_imports', [
        'product' => $product->code,
    ]);
});

test('price shows correct if within tolerance', function () {
    $product = $this->products->first();

    Price::where('customer_code', $this->user->customer->code)->where('product', $product->code)->update([
        'price' => 10.00,
        'break1' => null,
        'break2' => null,
        'break3' => null,
    ]);

    $this->followingRedirects()->post(route('upload-validate'), [
        'tolerance' => 0.10,
        'csv_file' => UploadedFile::fake()->createwithContent('test.csv', $product->code.',12,10.05')->mimeType('text/csv'),
    ])->assertSee('10.05')->assertDontSee('badge-danger');
});

test('price shows correct with tolerance if total price is passed', function () {
    $product = $this->products->first();

    Price::where('customer_code', $this->user->customer->code)->where('product', $product->code)->update([
        'price' => 10.00,
        'break1' => null,
        'break2' => null,
        'break3' => null,
    ]);

    $this->followingRedirects()->post(route('upload-validate'), [
        'tolerance' => 0.10,
        'csv_file' => UploadedFile::fake()->createwithContent('test.csv', $product->code.',10,100.05')->mimeType('text/csv'),
    ])->assertSee('100.05')->assertDontSee('badge-danger');
});
