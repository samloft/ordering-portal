<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Price;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => $user->customer_code,
            'product' => $product->code,
        ]);

        factory(Category::class)->create(['product' => $product->code]);

        $response = $this->actingAs($user)->get(route('products'));

        $response->assertOk();
        $response->assertViewIs('products.index');
        $response->assertViewHas('categories');
    }

    /**
     * @test
     */
    public function search_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('products.search'));

        $response->assertOk();
        $response->assertViewIs('products.products');
        $response->assertViewHas('products');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => $user->customer_code,
            'product' => $product->code,
        ]);

        $response = $this->actingAs($user)->get(route('products.show', [$product]));

        $response->assertOk();
        $response->assertViewIs('products.show');
        $response->assertViewHas('categories');
        $response->assertViewHas('product');
    }
}
