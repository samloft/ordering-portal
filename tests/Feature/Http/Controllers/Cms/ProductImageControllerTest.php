<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\ProductImageController
 */
class ProductImageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.product-images'));

        $response->assertOk();
        $response->assertViewIs('product-images.index');
    }

    /**
     * @test
     */
    public function missing_images_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.product-images.missing'));

        $response->assertOk();
    }

    ///**
    // * @test
    // */
    //public function store_returns_an_ok_response(): void
    //{
    //    $user = factory(Admin::class)->create();
    //
    //    $response = $this->actingAs($user, 'admin')->post(route('cms.product-images.store'), [// TODO: send request data
    //    ]);
    //
    //    $response->assertOk();
    //}
}
