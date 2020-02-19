<?php

namespace Tests\Feature;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class QuickBuyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_customer_can_quick_buy_products_on_their_price_list(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create([
            'order_multiples' => 1,
        ]);

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product' => $product->code,
        ]);

        $this->post(route('basket.add-product', [
            'product' => $product->code,
            'quantity' => 1,
            'update' => true,
        ]));

        $this->assertDatabaseHas('basket', [
            'user_id' => $user->id,
            'product' => $product->code,
            'quantity' => 1,
        ]);
    }

    /**
     * @test
     */
    public function a_customer_cannot_quick_buy_products_on_their_price_list(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create([
            'order_multiples' => 1,
        ]);

        factory(Price::class)->create([
            'customer_code' => 'ABC123',
            'product' => $product->code,
        ]);

        $this->post(route('basket.add-product'), [
            'product' => $product->code,
            'quantity' => 1,
            'update' => true,
        ]);

        $this->assertDatabaseMissing('basket', [
            'user_id' => $user->id,
            'product' => $product->code,
        ]);
    }

    /**
     * @test
     */
    public function qty_auto_increments_if_not_in_increments_of_order_multiples(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create([
            'order_multiples' => 10,
        ]);

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product' => $product->code,
        ]);

        $this->post(route('basket.add-product'), [
            'product' => $product->code,
            'quantity' => 7,
            'update' => true,
        ]);

        $this->assertDatabaseHas('basket', [
            'user_id' => $user->id,
            'product' => $product->code,
            'quantity' => 10,
        ]);
    }

    /**
     * @test
     */
    public function qty_does_not_increment_if_in_increments_of_order_multiples(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create([
            'order_multiples' => 10,
        ]);

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product' => $product->code,
        ]);

        $this->post(route('basket.add-product'), [
            'product' => $product->code,
            'quantity' => 50,
            'update' => true,
        ]);

        $this->assertDatabaseHas('basket', [
            'user_id' => $user->id,
            'product' => $product->code,
            'quantity' => 50,
        ]);
    }
}
