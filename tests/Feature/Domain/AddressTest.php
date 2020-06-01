<?php

use App\Models\Address;
use App\Models\Basket;
use Illuminate\Support\Facades\Http;
use Tests\Setup\ProductFactory;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);
});

test('returns an ok response', function () {
    $this->get(route('account.addresses'))->assertStatus(200);
});

test('create returns an ok response', function () {
    $this->get(route('account.address.create'))->assertStatus(200);

    $this->get(route('account.address.create', ['checkout' => true]))->assertStatus(200);
});

test('selecting one that does not exists returns error', function () {
    $this->get(route('account.address.select', ['id' => 999]))->assertSessionHas('error')->assertStatus(302);
});

test('selecting default address clears the session', function () {
    session([
        'address' => [
            'address_id' => 999,
        ]
    ]);

    $this->get(route('account.address.select'))->assertSessionMissing('address')->assertStatus(302);
});

test('session is forgot', function () {
    session([
        'address' => [
            'address_id' => 1,
            'company_name' => 'Name',
            'address_line_2' => 'Line 2',
            'address_line_3' => 'Line 3',
            'address_line_4' => 'Line 4',
            'address_line_5' => 'Line 5',
            'post_code' => 'POST CODE',
        ],
    ]);

    $this->get(route('account.addresses'))->assertSessionMissing('address');
});

test('can be created', function () {
    $address = [
        'company name' => 'Test name',
        'address_line_2' => 'Address Line 2',
        'address_line_3' => 'Address Line 3',
        'address_line_5' => 'Address Line 5',
        'country' => 'UK',
        'post_code' => 'ABC 123',
    ];

    $this->post(route('account.address.store', $address))->assertSessionHas('success')->assertStatus(302);

    $this->assertDataBaseHas('addresses', [
        'user_id' => $this->user->id,
        'customer_code' => $this->user->customer->code,
    ]);
});

test('can be updated', function () {
    $address = factory(Address::class, 1)->create([
        'customer_code' => $this->user->customer->code,
    ])->first();

    $this->patch(route('account.address.update', ['id' => $address->id]), [
        'company_name' => 'Updated!',
        'address_line_2' => 'Address Line',
        'address_line_3' => 'Address Line',
        'address_line_5' => 'Address Line',
        'country' => 'UK',
        'post_code' => 'ABC123',
    ])->assertStatus(302);

    $this->assertDatabaseHas('addresses', [
        'company_name' => 'Updated!',
    ]);
});

test('cannot update another users address', function () {
    $address = factory(Address::class, 1)->create([
        'customer_code' => 'TEST123',
    ])->first();

    $this->patch(route('account.address.update', ['id' => $address->id]), [
        'company_name' => 'Updated!',
        'address_line_2' => $address->address_line_2,
        'address_line_3' => $address->address_line_3,
        'address_line_5' => $address->address_line_5,
        'country' => 'UK',
        'post_code' => 'ABC123',
    ])->assertStatus(302);

    $this->assertDatabaseMissing('addresses', [
        'company_name' => 'Updated!',
    ]);
});

test('can be deleted', function () {
    $address = factory(Address::class, 1)->create([
        'customer_code' => $this->user->customer->code,
    ])->first();

    $this->get(route('account.address.destroy', ['id' => $address->id]))->assertSessionHas('success');

    $this->assertDeleted('addresses', ['id' => $address->id]);
});

test('cannot delete another users address', function () {
    $address = factory(Address::class, 1)->create([
        'customer_code' => 'NOTMYCUTOMER',
    ])->first();

    $this->get(route('account.address.destroy', ['id' => $address->id]))->assertSessionHas('error');

    $this->assertDatabaseHas('addresses', [
        'company_name' => $address->company_name,
    ]);
});

test('cannot see another users address', function () {
    $address = factory(Address::class, 1)->create([
        'customer_code' => 'NOTMYCUTOMER',
    ])->first();

    $this->get(route('account.address.edit', ['id' => $address->id]))->assertStatus(404);
});

test('selecting address from checkout goes back to checkout and sets address session', function () {
    $product = (new ProductFactory())->withPrices($this->user->customer->code)->create()->first();

    factory(Basket::class, 1)->create([
        'product' => $product->code,
        'customer_code' => $this->user->customer->code,
        'user_id' => $this->user->id,
    ]);

    $address = factory(Address::class, 1)->create([
        'customer_code' => $this->user->customer->code,
    ])->first();

    $this->followingRedirects()->get(route('account.address.select', ['id' => $address->id]))
        ->assertSee('Complete your order');
});

test('creating address from checkout goes back to checkout and sets address session', function () {
    $product = (new ProductFactory())->withPrices($this->user->customer->code)->create()->first();

    factory(Basket::class, 1)->create([
        'product' => $product->code,
        'customer_code' => $this->user->customer->code,
        'user_id' => $this->user->id,
    ]);

    $address = [
        'checkout' => 1,
        'company name' => 'Test name',
        'address_line_2' => 'Address Line 2',
        'address_line_3' => 'Address Line 3',
        'address_line_5' => 'Address Line 5',
        'country' => 'UK',
        'post_code' => 'ABC 123',
    ];

    $this->followingRedirects()->post(route('account.address.store', $address))->assertSee('Complete your order')
        ->assertSee('Test name');
});

test('lookup requires a postcode', function () {
   $this->get(route('account.address.lookup'))->assertSessionHasErrors();
});

test('lookup returns ok json response if exists', function () {
    Http::fake([
        '*' => Http::response(['address' => ''], 200),
    ]);

    $this->get(route('account.address.lookup', ['postcode' => 'ABC123']))->assertStatus(200)->assertJson([
        'address' => '',
    ]);
});

test('lookup returns not found if none exist', function () {
    Http::fake([
        '*' => Http::response([], 404),
    ]);

    $this->get(route('account.address.lookup', ['postcode' => 'ABC123']))->assertStatus(404)->assertJson([]);
});
