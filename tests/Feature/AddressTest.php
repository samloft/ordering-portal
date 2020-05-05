<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use App\Models\Address;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_create_a_address(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $address = [
            'company_name' => 'Test name',
            'address_line_2' => 'Address Line 2',
            'address_line_3' => 'Address Line 3',
            'address_line_5' => 'Address Line 5',
            'country' => 'UK',
            'post_code' => 'ABC 123',
            'default' => true,
        ];

        $this->post(route('account.address.store', $address));

        $this->assertDatabaseHas('addresses', $address);
    }

    /**
     * @test
     */
    public function a_user_can_edit_a_address(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $address = factory(Address::class, 1)->create()->first();

        $address->company_name = 'Updated name';

        $this->patch(route('account.address.update', $address->toArray()));

        $this->assertDatabaseHas('addresses', [
            'company_name' => 'Updated name'
        ]);
    }

    /**
     * @test
     */
    public function a_user_can_delete_a_address(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $address = factory(Address::class, 1)->create()->first();

        $this->delete(route('account.address.destroy', ['id' => $address->id]));

        $this->assertDatabaseMissing('addresses', $address->toArray());
    }

    /**
     * @test
     */
    public function a_user_can_set_address_as_default(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $address = factory(Address::class, 1)->create([
            'default' => false,
        ])->first();

        $this->post(route('account.address.default', ['id' => $address->id]));

        $this->assertDatabaseHas('addresses', ['default' => true]);
    }

    /**
     * @test
     */
    public function a_user_cannot_edit_another_users_address(): void
    {
        $address = factory(Address::class, 1)->create([
            'id' => 99,
            'customer_code' => 'ABC123',
        ])->first();

        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $this->patch(route('account.address.update', [
            'id' => $address->id,
            'company_name' => 'Changed',
        ]));

        $this->assertDatabaseMissing('addresses', ['company_name' => 'Changed']);
    }

    /**
     * @test
     */
    public function a_user_cannot_delete_someone_else_address(): void
    {
        $address = factory(Address::class, 1)->create([
            'id' => 99,
            'customer_code' => 'ABC123',
        ])->first();

        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $this->delete(route('account.address.destroy', ['id' => $address->id]));

        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }
}
