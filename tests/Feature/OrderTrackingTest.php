<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\OrderTrackingFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class OrderTrackingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_customer_can_see_past_orders(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $orders = (new OrderTrackingFactory(10))->create([
            'customer_code' => $user->customer->code,
        ]);

        foreach ($orders as $order) {
            $this->get(route('order-tracking'))->assertSee($order->order_number);
        }
    }

    /**
     * @test
     */
    public function a_customer_cannot_see_an_order_not_placed_by_them(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        (new OrderTrackingFactory(5))->create([
            'customer_code' => $user->customer->code,
        ]);

        $order = (new OrderTrackingFactory())->create([
            'customer_code' => 'ABC123',
        ]);

        $this->get(route('order-tracking'))->assertDontSee($order->first()->order_number);
    }

    /**
     * @test
     */
    public function a_customer_can_search_for_an_order(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $order = (new OrderTrackingFactory())->create([
            'customer_code' => $user->customer->code,
        ])->first();

        $this->get(route('order-tracking', ['keyword' => $order->order_number]))->assertSee($order->order_number)->assertSee($order->reference)->assertSee($order->status);
    }

    /**
     * @test
     */
    public function a_customer_can_view_a_previous_order(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $order = (new OrderTrackingFactory())->withLines()->create([
            'customer_code' => $user->customer->code,
        ])->first();

        $this->get(route('order-tracking.show', ['order' => $order->order_number]))->assertSee($order->order_number)->assertSee($order->lines->first()->product);
    }

    /**
     * @test
     */
    public function a_customer_cannot_view_another_customers_order(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $order = (new OrderTrackingFactory())->withLines()->create([
            'customer_code' => 'ABC123',
        ])->first();

        $this->get(route('order-tracking.show', ['order' => $order->order_number]))->assertStatus(404);
    }

    /**
     * @test
     */
    public function a_customer_can_copy_an_order_to_basket(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $order = (new OrderTrackingFactory())->withLines()->create([
            'customer_code' => $user->customer->code,
        ])->first();

        $this->get(route('order-tracking.copy-to-basket', ['order_number' => encodeUrl(trim($order->order_number))]));

        foreach ($order->lines as $order) {
            $this->assertDatabaseHas('basket', [
                'user_id' => $user->id,
                'customer_code' => $user->customer->code,
                'product' => $order->product,
                'quantity' => $order->quantity,
            ]);
        }
    }
}
