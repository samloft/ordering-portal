<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AddressController
 */
class AddressControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('account.address.create'));

        $response->assertOk();
        $response->assertViewIs('addresses.show');
        $response->assertViewHas('countries');
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('account.addresses'));

        $response->assertOk();
        $response->assertViewIs('addresses.index');
        $response->assertViewHas('addresses');
        $response->assertViewHas('checkout');
    }

    /**
     * @test
     */
    public function select_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();
        $address = factory(Address::class)->create(['user_id' => $user->id, 'customer_code' => $user->customer_code]);

        $response = $this->actingAs($user)->get(route('account.address.select', ['id' => $address->id]));

        $response->assertRedirect(route('checkout', ['account' => true]));
    }
}
