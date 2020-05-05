<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use App\Models\OrderHeader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\OrdersController
 */
class OrdersControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.orders'));

        $response->assertOk();
        $response->assertViewIs('orders.index');
        $response->assertViewHas('orders');
    }

    /**
     * @test
     */
    public function mark_for_import_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();
        $order = factory(OrderHeader::class)->create(['imported' => true]);

        $response = $this->actingAs($user, 'admin')->get(route('cms.orders.import', ['order_number' => $order->order_number]));

        $response->assertRedirect();
    }
}
