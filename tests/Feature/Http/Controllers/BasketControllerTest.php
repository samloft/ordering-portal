<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Basket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProductFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BasketController
 */
class BasketControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function add_product_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();
        $product = (new ProductFactory())->withPrices($user->customer_code)->create()->first();

        $response = $this->actingAs($user)->post(route('basket.add-product'), [
            'product' => $product->code,
            'quantity' => $product->order_multiples,
        ]);

        $response->assertOk();
    }

    /**
     * @test
     */
    public function clear_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('basket.empty'));

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('basket'));

        $response->assertOk();
        $response->assertViewIs('basket.index');
        $response->assertViewHas('basket');
    }

    /**
     * @test
     */
    public function remove_product_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();
        $product = (new ProductFactory())->withPrices($user->customer_code)->create()->first();
        factory(Basket::class)->create(['product' => $product->code]);

        $response = $this->actingAs($user)->post(route('basket.delete-line'), [
            'product' => $product->code,
        ]);

        $response->assertOk();
    }
}
