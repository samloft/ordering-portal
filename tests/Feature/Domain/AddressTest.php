<?php

use App\Models\Address;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);
});

test('returns an ok response', function () {
    $this->get(route('account.addresses'))->assertStatus(200);
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
        'address_line_2' => $address->address_line_2,
        'address_line_3' => $address->address_line_3,
        'address_line_5' => $address->address_line_5,
        'country' => $address->country,
        'post_code' => $address->post_code,
    ])->assertSessionHas('success')->assertStatus(302);

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
        'country' => $address->country,
        'post_code' => $address->post_code,
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

test('cannot delete another users address');

test('cannot see another users address');

test('selecting address from basket goes back to basket and sets address session');

test('creating address from basket goes back to basket and sets address session');

test('default customer record address is used if no address session');

//
//    /**
//     * @test
//     */
//    public function a_user_can_edit_a_address(): void
//    {
//        $user = (new UserFactory())->withCustomer()->create();
//
//        $this->signIn($user);
//
//        $address = factory(Address::class)->create([
//            'user_id' => auth()->id(),
//            'customer_code' => auth()->user()->customer->code,
//        ]);
//
//        $address->company_name = 'Updated name';
//
//        $this->patch(route('account.address.update', $address->toArray()));
//
//        $this->assertDatabaseHas('addresses', ['company_name' => $address->company_name]);
//    }
//
//    /**
//     * @test
//     */
//    public function a_user_can_delete_a_address(): void
//    {
//        $user = (new UserFactory())->withCustomer()->create();
//
//        $this->signIn($user);
//
//        $address = factory(Address::class, 1)->create()->first();
//
//        $this->delete(route('account.address.destroy', ['id' => $address->id]));
//
//        $this->assertDatabaseMissing('addresses', $address->toArray());
//    }
//
//    /**
//     * @test
//     */
//    public function a_user_cannot_edit_another_users_address(): void
//    {
//        $address = factory(Address::class, 1)->create([
//            'id' => 99,
//            'customer_code' => 'ABC123',
//        ])->first();
//
//        $user = (new UserFactory())->withCustomer()->create();
//
//        $this->signIn($user);
//
//        $this->patch(route('account.address.update', [
//            'id' => $address->id,
//            'company_name' => 'Changed',
//        ]));
//
//        $this->assertDatabaseMissing('addresses', ['company_name' => 'Changed']);
//    }
//
//    /**
//     * @test
//     */
//    public function a_user_cannot_delete_someone_else_address(): void
//    {
//        $address = factory(Address::class, 1)->create([
//            'id' => 99,
//            'customer_code' => 'ABC123',
//        ])->first();
//
//        $user = (new UserFactory())->withCustomer()->create();
//
//        $this->signIn($user);
//
//        $this->delete(route('account.address.destroy', ['id' => $address->id]));
//
//        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
//    }
//}
