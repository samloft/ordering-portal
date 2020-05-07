<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\PagesController
 */
class PagesControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function accessibility_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.pages.accessibility'));

        $response->assertOk();
        $response->assertViewIs('pages.index');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function data_protection_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.pages.data-protection'));

        $response->assertOk();
        $response->assertViewIs('pages.index');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.pages.store'), [
            'name' => 'terms-and-conditions',
            'description' => 'Example Test',
        ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function terms_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.pages.terms'));

        $response->assertOk();
        $response->assertViewIs('pages.index');
        $response->assertViewHas('data');
    }
}
