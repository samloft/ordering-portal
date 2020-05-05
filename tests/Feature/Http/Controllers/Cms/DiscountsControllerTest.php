<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use App\Models\CustomerDiscount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\DiscountsController
 */
class DiscountsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();
        $customer_discount = factory(CustomerDiscount::class)->create();

        $response = $this->actingAs($user, 'admin')
            ->delete(route('cms.discounts.customer-destroy', ['id' => $customer_discount->id]));

        $response->assertOk();
        $this->assertDeleted($customer_discount);
    }

    /**
     * @test
     */
    public function global_store_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.discounts.global-store'), [
            'global_discount' => 2,
        ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.discounts'));

        $response->assertOk();
        $response->assertViewIs('discounts.index');
        $response->assertViewHas('global_discount');
        $response->assertViewHas('customer_discounts');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.discounts.customer-store'), [
                'customer' => 'ABC123',
                'discount' => 2,
            ]);

        $response->assertRedirect();
    }
}
