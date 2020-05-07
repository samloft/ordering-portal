<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProductDataController
 */
class ProductDataControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function data_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('product-data.data'));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('product-data'));

        $response->assertOk();
        $response->assertViewIs('product-data.index');
        $response->assertViewHas('product_data');
        $response->assertViewHas('brands');
    }

    /**
     * @test
     */
    public function prices_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('product-data.prices'));

        $response->assertOk();
    }
}
