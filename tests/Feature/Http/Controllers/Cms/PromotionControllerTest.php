<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use App\Models\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\PromotionController
 */
class PromotionControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $promotion = factory(Promotion::class)->create();

        $response = $this->actingAs($user, 'admin')->delete(route('cms.promotions.destroy', ['id' => $promotion->id]));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $promotion = factory(Promotion::class)->create();

        $response = $this->actingAs($user, 'admin')->patch(route('cms.promotions.update', ['id' => $promotion->id]), [
                'promotion_product' => 'CMA036',
            ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.promotions'));

        $response->assertOk();
        $response->assertViewIs('promotions.index');
        $response->assertViewHas('promotions');
        $response->assertViewHas('buying_groups');
        $response->assertViewHas('price_lists');
        $response->assertViewHas('discount_codes');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.promotions.store'), [
            'type' => 'product',
            'product' => 'CMA036',
            'product_qty' => 10,
            'promotion_product' => 'CMA036',
            'promotion_qty' => 5,
            'claim_type' => 'multiple',
            'max_claims' => 5,
            'start_date' => date('Y-m-d'),
            'restrictions' => null,
        ]);

        $response->assertRedirect();
    }
}
