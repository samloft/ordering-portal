<?php

use App\Models\Basket;
use App\Models\Price;
use App\Models\Product;
use App\Models\Promotion;
use Carbon\Carbon;
use Tests\Setup\BasketFactory;
use Tests\Setup\OrderFactory;
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

test('quantity needs to be a valid number', function () {
    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    $this->post('basket/add-product', [
        'product' => $this->product->code,
        'quantity' => 'a',
        'update' => false,
    ])->assertStatus(422)->assertSee('not a valid quantity');

    $this->post('basket/add-product', [
        'product' => $this->product->code,
        'quantity' => '',
        'update' => false,
    ])->assertStatus(422)->assertSee('not a valid quantity');

    $this->post('basket/add-product', [
        'product' => $this->product->code,
        'quantity' => 0,
        'update' => false,
    ])->assertStatus(422)->assertSee('not a valid quantity');
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

test('prices get adjusted when a bulk rate is met', function () {
    $product = (new BasketFactory())->create()->first();

    Price::where('customer_code', $this->user->customer->code)->where('product', $product->code)->update([
        'price' => 10.00,
        'price1' => 5.00,
        'break1' => 500,
        'price2' => 4.00,
        'break2' => 600,
        'price3' => 3.00,
        'break3' => 700,
    ]);

    Basket::where('user_id', $this->user->id)->where('product', $product->code)->update([
        'quantity' => 500,
    ]);

    $this->get(route('basket'))->assertSee(discount('5.00'));

    Basket::where('user_id', $this->user->id)->where('product', $product->code)->update([
        'quantity' => 600,
    ]);

    $this->get(route('basket'))->assertSee(discount('4.00'));

    Basket::where('user_id', $this->user->id)->where('product', $product->code)->update([
        'quantity' => 700,
    ]);

    $this->get(route('basket'))->assertSee(discount('3.00'));
});

test('default customer record address is used if no address session', function () {
    $this->get(route('basket'))->assertSee($this->user->customer->name);
});

test('promotional product is added to basket', function () {
    $product = (new BasketFactory())->create()->first();

    Basket::where('user_id', $this->user->id)->where('product', $product->code)->update([
        'quantity' => 10,
    ]);

    factory(Promotion::class)->create([
        'name' => 'Promotion',
        'type' => 'product',
        'product' => $product->code,
        'product_qty' => 10,
        'promotion_product' => 'FOC',
        'promotion_qty' => 5,
        'claim_type' => 'multiple',
        'max_claims' => 5,
        'start_date' => date('d-m-Y'),
        'end_date' => null,
        'restrictions' => null,
    ]);

    $this->get(route('basket'))->assertOk()->assertSee('FOC');
});

test('promotional product is added to basket only once with per order', function () {
    $product = (new BasketFactory())->create()->first();

    Basket::where('user_id', $this->user->id)->where('product', $product->code)->update([
        'quantity' => 20,
    ]);

    factory(Promotion::class)->create([
        'name' => 'Promotion',
        'type' => 'product',
        'product' => $product->code,
        'product_qty' => 10,
        'promotion_product' => 'FOC',
        'promotion_qty' => 100,
        'claim_type' => 'per_order',
        'max_claims' => null,
        'start_date' => date('d-m-Y'),
        'end_date' => null,
        'restrictions' => null,
    ]);

    $this->get(route('basket'))->assertOk()->assertSee('FOC')->assertSee('"quantity":100');
});

test('value promotion with product is added', function () {
    $product = (new BasketFactory())->create()->first();

    Basket::where('user_id', $this->user->id)->where('product', $product->code)->update([
        'quantity' => 100000,
    ]);

    factory(Promotion::class)->create([
        'name' => 'Promotion',
        'type' => 'value',
        'minimum_value' => 1,
        'value_reward' => 'product',
        'promotion_product' => 'FOC',
        'promotion_qty' => 5,
        'claim_type' => 'multiple',
        'max_claims' => 5,
        'start_date' => date('d-m-Y'),
        'end_date' => null,
        'restrictions' => null,
    ]);

    $this->get(route('basket'))->assertOk()->assertSee('FOC');
});

test('value promotion with discount is added', function () {
    $product = (new BasketFactory())->create()->first();

    Basket::where('user_id', $this->user->id)->where('product', $product->code)->update([
        'quantity' => 100000,
    ]);

    factory(Promotion::class)->create([
        'name' => 'Promotion',
        'type' => 'value',
        'minimum_value' => 1,
        'value_reward' => 'percent',
        'value_percent' => 10,
        'claim_type' => 'multiple',
        'max_claims' => 5,
        'start_date' => date('d-m-Y'),
        'end_date' => null,
        'restrictions' => null,
    ]);

    $this->get(route('basket'))->assertOk()->assertSee('order_discount');
});

test('product promotion prompt is displayed if 75% towards reaching it', function () {
    $product = (new BasketFactory())->create()->first();

    Basket::where('user_id', $this->user->id)->where('product', $product->code)->update([
        'quantity' => 9,
    ]);

    factory(Promotion::class)->create([
        'name' => 'Promotion',
        'type' => 'product',
        'product' => $product->code,
        'product_qty' => 10,
        'promotion_product' => 'FOC',
        'promotion_qty' => 5,
        'claim_type' => 'multiple',
        'max_claims' => 5,
        'start_date' => date('d-m-Y'),
        'end_date' => null,
        'restrictions' => null,
    ]);

    $this->get(route('basket'))->assertOk()->assertSee('1 '.$product->code)->assertSee('1 FOC');
});

test('value promotion prompt is displayed if 75% towards it', function () {
    $product = factory(Product::class)->create()->first();

    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $product->code,
        'price' => 11.00,
        'price1' => null,
        'break1' => null,
        'price2' => null,
        'break2' => null,
        'price3' => null,
        'break3' => null,
    ]);

    Promotion::create([
        'name' => 'Promotion',
        'type' => 'value',
        'minimum_value' => 100,
        'value_reward' => 'percent',
        'value_percent' => 10,
        'claim_type' => 'multiple',
        'max_claims' => 5,
        'start_date' => date('d-m-Y'),
        'end_date' => null,
        'restrictions' => null,
    ]);

    factory(Basket::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $product->code,
        'quantity' => 9,
    ]);

    $this->get(route('basket'))->assertOk()->assertSee('away from getting 10');
});

test('value promotion not displayed if less than 75% towards it', function () {
    $product = factory(Product::class)->create()->first();

    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $product->code,
        'price' => 1.00,
        'price1' => null,
        'break1' => null,
        'price2' => null,
        'break2' => null,
        'price3' => null,
        'break3' => null,
    ]);

    Promotion::create([
        'name' => 'Promotion',
        'type' => 'value',
        'minimum_value' => 100,
        'value_reward' => 'percent',
        'value_percent' => 10,
        'claim_type' => 'multiple',
        'max_claims' => 5,
        'start_date' => date('d-m-Y'),
        'end_date' => null,
        'restrictions' => null,
    ]);

    factory(Basket::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $product->code,
        'quantity' => 5,
    ]);

    $this->get(route('basket'))->assertOk()->assertDontSee('away from getting 10');
});

test('value promotion with product reward can be claimed', function () {
    $product = factory(Product::class)->create()->first();

    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $product->code,
        'price' => 10.00,
        'price1' => null,
        'break1' => null,
        'price2' => null,
        'break2' => null,
        'price3' => null,
        'break3' => null,
    ]);

    Promotion::create([
        'name' => 'Promotion',
        'type' => 'value',
        'minimum_value' => 100,
        'promotion_product' => 'FOC',
        'promotion_qty' => 5,
        'claim_type' => 'multiple',
        'max_claims' => 5,
        'start_date' => date('d-m-Y'),
        'end_date' => null,
        'restrictions' => null,
    ]);

    factory(Basket::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $product->code,
        'quantity' => 10,
    ]);

    $this->get(route('basket'))->assertOk()->assertSee('FOC');
});

test('promotions cannot be claimed more than allowed', function () {
    (new OrderFactory())->withLine([
        'product' => 'FOC',
        'quantity' => 5,
        'stock_type' => 'PROMO',
    ])->create([
        'customer_code' => $this->user->customer->code,
    ]);

    factory(Price::class)->create([
        'customer_code' => $this->user->customer->code,
        'product' => $this->product->code,
    ]);

    factory(Promotion::class)->create([
        'name' => 'Promotion',
        'type' => 'product',
        'product' => $this->product->code,
        'product_qty' => 10,
        'promotion_product' => 'FOC',
        'promotion_qty' => 5,
        'claim_type' => 'multiple',
        'max_claims' => 1,
        'start_date' => Carbon::now()->subDay(),
        'end_date' => Carbon::now()->addDay(),
        'restrictions' => null,
    ]);

    factory(Basket::class)->create([
        'product' => $this->product->code,
        'customer_code' => $this->user->customer->code,
        'user_id' => $this->user->id,
        'quantity' => 10,
    ]);

    $this->get(route('basket'))->assertOk()->assertDontSee('FOC');
});
