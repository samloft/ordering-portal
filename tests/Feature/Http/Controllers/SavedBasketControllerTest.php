<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\SavedBasket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\BasketFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SavedBasketController
 */
class SavedBasketControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function copy_to_basket_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $saved_basket = factory(SavedBasket::class)->create([
            'user_id' => $user->id,
            'customer_code' => $user->customer_code,
        ]);

        $response = $this->actingAs($user)->get(route('saved-baskets.copy', ['reference' => $saved_basket->reference]));

        $response->assertRedirect(route('basket'));
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $saved_basket = factory(SavedBasket::class)->create([
            'user_id' => $user->id,
            'customer_code' => $user->customer_code,
        ]);

        $response = $this->actingAs($user)->get(route('saved-baskets.destroy', ['reference' => $saved_basket->reference]));

        $response->assertRedirect(route('saved-baskets'));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('saved-baskets'));

        $response->assertOk();
        $response->assertViewIs('saved-baskets.index');
        $response->assertViewHas('saved_baskets');
        $response->assertViewHas('search');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $saved_basket = factory(SavedBasket::class)->create([
            'user_id' => $user->id,
            'customer_code' => $user->customer_code,
        ]);

        $response = $this->actingAs($user)->get(route('saved-baskets.show', ['reference' => $saved_basket->reference]));

        $response->assertOk();
        $response->assertViewIs('saved-baskets.show');
        $response->assertViewHas('saved_basket');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        (new BasketFactory())->create();

        $response = $this->post(route('saved-baskets.store'), ['reference' => 'new-saved-basket']);

        $response->assertOk();
    }
}
