<?php

use App\Models\Admin;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake();

    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.product-images'))->assertOk();
});

test('products with missing images are returned', function () {
    $product = factory(Product::class)->create();

    factory(Price::class)->create([
        'product' => $product->code,
    ]);

    $this->get(route('cms.product-images.missing'))->assertOk()->assertSee($product->code);
});

test('image can be uploaded', function () {
    $this->post(route('cms.product-images.store'), [
        'file' => UploadedFile::fake()->image('product.png'),
    ])->assertOk();

    Storage::assertExists('product.png');
});
