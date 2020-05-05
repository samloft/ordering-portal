<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\HomeController
 */
class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.index'));

        $response->assertOk();
        $response->assertViewIs('dashboard.index');
        $response->assertViewHas('stats');
    }
}
