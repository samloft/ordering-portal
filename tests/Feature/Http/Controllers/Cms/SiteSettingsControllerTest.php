<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\SiteSettingsController
 */
class SiteSettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.site-settings'));

        $response->assertOk();
        $response->assertViewIs('site-settings.index');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')
            ->patch(route('cms.site-settings.update'), [
                'announcement' => 'test',
            ]);

        $response->assertRedirect();
    }
}
