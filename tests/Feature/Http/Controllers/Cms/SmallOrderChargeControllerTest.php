<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\SmallOrderChargeController
 */
class SmallOrderChargeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.small-order'));

        $response->assertOk();
        $response->assertViewIs('small-order.index');
        $response->assertViewHas('small_order_rules');
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.small-order.update'), [
            'threshold' => 10,
            'charge' => 1,
            'exclude_on_charge_delivery' => false,
            'exclude_on_collection' => false,

        ]);

        $response->assertRedirect();
    }
}
