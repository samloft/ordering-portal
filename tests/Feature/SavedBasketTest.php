<?php

namespace Tests\Feature;

use App\Models\SavedBasket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\BasketFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class SavedBasketTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_customer_can_create_a_saved_basket(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $products = (new BasketFactory())->create();

        $this->post(route('saved-baskets.store', ['reference' => 'test-basket']));

        foreach ($products as $product) {
            $this->assertDatabaseHas('saved_baskets', [
                'customer_code' => $user->customer->code,
                'user_id' => $user->id,
                'product' => $product->code,
                'reference' => 'test-basket',
            ]);
        }
    }

    /**
     * @test
     */
    public function a_customer_can_delete_a_saved_basket(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        (new BasketFactory())->create();

        $this->post(route('saved-baskets.store', ['reference' => 'test-basket']));

        $basket_id = SavedBasket::where('reference', 'test-basket')->first()->id;

        $this->get(route('saved-baskets.destroy', ['id' => $basket_id]));

        $this->assertDatabaseMissing('saved_baskets', [
            'reference' => 'test-basket',
        ]);
    }

    /**
     * @test
     */
    public function a_customer_can_see_a_saved_basket_in_the_list(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        (new BasketFactory())->create();

        $this->post(route('saved-baskets.store', ['reference' => 'test-basket']));

        $this->get(route('saved-baskets'))->assertSee('test-basket');
    }

    /**
     * @test
     */
    public function a_customer_can_see_their_saved_basket(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $products = (new BasketFactory())->create();

        $this->post(route('saved-baskets.store', ['reference' => 'test-basket']));

        $basket_id = SavedBasket::where('reference', 'test-basket')->first()->id;

        $this->get(route('saved-baskets.show', ['id' => $basket_id]))->assertStatus(200)->assertSee('test-basket')
            ->assertSee($products->first()->code);
    }

    /**
     * @test
     */
    public function a_customer_cannot_see_another_customers_saved_basket(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        (new BasketFactory())->create();

        $this->post(route('saved-baskets.store', ['reference' => 'test-basket']));

        $basket = SavedBasket::where('reference', 'test-basket');
        $basket->update(['customer_code' => 'ABC123']);

        $this->get(route('saved-baskets.show', ['id' => $basket->first()->id]))->assertStatus(404);
    }

    /**
     * @test
     */
    public function a_customer_can_add_a_saved_basket_to_the_basket(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $products = (new BasketFactory())->create();

        $this->post(route('saved-baskets.store', ['reference' => 'test-basket']));

        $basket_id = SavedBasket::where('reference', 'test-basket')->first()->id;

        $this->get(route('saved-baskets.store', ['id' => $basket_id]));

        foreach ($products as $product) {
            $this->assertDatabaseHas('basket', [
                'user_id' => $user->id,
                'customer_code' => $user->customer->code,
                'product' => $product->code,
            ]);
        }
    }
}
