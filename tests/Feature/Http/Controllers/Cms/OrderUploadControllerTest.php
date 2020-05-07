<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\OrderUploadController
 */
class OrderUploadControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.order-upload'));

        $response->assertOk();
        $response->assertViewIs('order-upload.index');
        $response->assertViewHas('settings');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.order-upload.store'), [
            'price' => false,
            'packs' => false,
        ]);

        $response->assertRedirect();
    }
}
