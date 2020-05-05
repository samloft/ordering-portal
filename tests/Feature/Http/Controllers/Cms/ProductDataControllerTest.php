<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\ProductDataController
 */
class ProductDataControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.product-data'));

        $response->assertOk();
        $response->assertViewIs('product-data-settings.index');
        $response->assertViewHas('settings');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->patch(route('cms.product-data.update'), [
            'data' => false,
            'prices' => false,
        ]);

        $response->assertRedirect();
    }
}
