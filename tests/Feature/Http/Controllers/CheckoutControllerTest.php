<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\OrderHeader;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\BasketFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CheckoutController
 */
class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function confirmation_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $order = factory(OrderHeader::class)->create([
            'customer_code' => $user->customer_code,
            'user_id' => $user->id,
        ]);

        $this->signIn($user);

        $response = $this->get(route('checkout.confirmation', ['order_number' => $order->order_number]));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();
        $this->signIn($user);

        $response = $this->get(route('checkout'));

        $response->assertRedirect(route('basket'));

        (new BasketFactory())->create();

        $response = $this->get(route('checkout'));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();
        $this->signIn($user);

        $response = $this->post(route('checkout.order'));

        $response->assertRedirect();
    }
}
