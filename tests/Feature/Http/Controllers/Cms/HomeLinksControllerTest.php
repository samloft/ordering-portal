<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\HomeLink;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\HomeLinksController
 */
class HomeLinksControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $home_link = factory(HomeLink::class)->create();

        $response = $this->actingAs($user, 'admin')->delete(route('cms.home-links.delete', ['id' => $home_link->id]));

        $response->assertOk();
        $this->assertDeleted($home_link);
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.home-links'));

        $response->assertOk();
        $response->assertViewIs('home-links.index');
        $response->assertViewHas('category_top_level');
        $response->assertViewHas('categories');
        $response->assertViewHas('adverts');
        $response->assertViewHas('banners');
    }

    ///**
    // * @test
    // */
    //public function store_returns_an_ok_response(): void
    //{
    //    $user = factory(Admin::class)->create();
    //
    //    $response = $this->actingAs($user, 'admin')->post(route('cms.home-links.store'), [// TODO: send request data
    //    ]);
    //
    //    $response->assertOk();
    //}

    ///**
    // * @test
    // */
    //public function update_positions_returns_an_ok_response(): void
    //{
    //    $user = factory(Admin::class)->create();
    //
    //    $response = $this->actingAs($user, 'admin')->patch(route('cms.home-links.update'), [// TODO: send request data
    //    ]);
    //
    //    $response->assertOk();
    //}
}
