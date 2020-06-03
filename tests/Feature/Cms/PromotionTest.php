<?php

use App\Models\Admin;
use App\Models\Product;
use App\Models\Promotion;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.promotions'))->assertOk();
});

test('can be created', function () {
    $product = factory(Product::class)->create();

    $this->followingRedirects()->post(route('cms.promotions.store'), $promotion = [
        'name' => 'Promotion',
        'type' => 'product',
        'product' => $product->code,
        'product_qty' => 10,
        'promotion_product' => $product->code,
        'promotion_qty' => 5,
        'claim_type' => 'multiple',
        'max_claims' => 5,
        'start_date' => date('d-m-Y'),
        'restrictions' => '',
    ])->assertOk();

    $this->assertDatabaseHas('promotions', [
        'name' => 'Promotion',
    ]);
});

test('can be updated', function () {
    $product = factory(Product::class)->create();

    $promotion = factory(Promotion::class)->create();

    $this->patch(route('cms.promotions.update', ['id' => $promotion->id]), [
        'name' => 'updated',
        'type' => 'product',
        'product' => $product->code,
        'product_qty' => 10,
        'promotion_product' => $product->code,
        'promotion_qty' => 5,
        'claim_type' => 'multiple',
        'max_claims' => 5,
        'start_date' => date('d-m-Y'),
        'restrictions' => '',
    ])->assertOk();

    $this->assertDatabaseHas('promotions', [
        'name' => 'updated',
    ]);
});

test('can be deleted', function () {
    $promotion = factory(Promotion::class)->create();

    $this->delete(route('cms.promotions.destroy', ['id' => $promotion->id]))->assertOk();

    $this->assertSoftDeleted('promotions', [
        'id' => $promotion->id,
    ]);
});
