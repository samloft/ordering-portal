<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\OrderTrackingFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderTrackingController
 */
class OrderTrackingControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function copy_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $order = (new OrderTrackingFactory())->withLines()->create([
            'customer_code' => $user->customer_code,
        ])->first();

        $response = $this->get(route('order-tracking.copy-to-basket', $order));

        $response->assertRedirect(route('basket'));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        (new OrderTrackingFactory())->withLines()->create([
            'customer_code' => $user->customer_code,
        ]);

        $response = $this->get(route('order-tracking'));

        $response->assertOk();
        $response->assertViewIs('order-tracking.index');
        $response->assertViewHas('orders');
    }

    ///**
    // * @test
    // */
    //public function invoice_pdf_returns_an_ok_response(): void
    //{
    //    $user = (new UserFactory())->withCustomer()->create();
    //
    //    $order = (new OrderTrackingFactory())->withLines()->create([
    //        'customer_code' => $user->customer_code,
    //    ])->first();
    //
    //    $response = $this->actingAs($user)->get(route('order-tracking.invoice-pdf', [
    //        'order' => $order->order_number,
    //        'customer' => $order->reference,
    //    ]));
    //
    //    $response->assertOk();
    //}

    /**
     * @test
     */
    public function order_details_p_d_f_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $order = (new OrderTrackingFactory())->withLines()->create([
            'customer_code' => $user->customer_code,
        ])->first();

        $response = $this->actingAs($user)->get(route('order-tracking.pdf', ['order' => $order->order_number]));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $order = (new OrderTrackingFactory())->withLines()->create([
            'customer_code' => $user->customer_code,
        ])->first();

        $response = $this->actingAs($user)->get(route('order-tracking.show', ['order' => $order->order_number]));

        $response->assertOk();
        $response->assertViewIs('order-tracking.show');
        $response->assertViewHas('order');
        $response->assertViewHas('lines');
    }
}
