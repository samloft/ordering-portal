<?php

namespace Tests\Feature;

use App\Models\Basket;
use App\Models\Price;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\BasketFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class BasketTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_customer_can_empty_the_basket(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $products = (new BasketFactory())->create();

        $this->post(route('basket.empty'));

        foreach ($products as $product) {
            $this->assertDatabaseMissing('basket', [
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
    public function a_product_line_can_be_removed(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = (new BasketFactory())->create()->first();

        $this->assertDatabaseHas('basket', [
            'product' => $product->code,
        ]);

        $this->post(route('basket.delete-line', ['product' => $product->code]));

        $this->assertDatabaseMissing('basket', [
            'product' => $product->code,
        ]);
    }

    /**
     * @test
     */
    public function a_product_line_can_have_its_qty_updated(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = (new BasketFactory())->create()->first();

        $this->post(route('basket.add-product', [
            'product' => $product->code,
            'quantity' => 1000,
            'update' => true,
        ]));

        $this->assertDatabaseHas('basket', [
            'product' => $product->code,
            'quantity' => 1000,
        ]);
    }

    /**
     * @test
     */
    public function bulk_savings_are_shown_if_within_range(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = (new BasketFactory())->create()->first();

        Price::where('customer_code', $user->customer->code)->where('product', $product->code)->update([
            'price' => 10.00,
            'price1' => 5.00,
            'break1' => 500,
        ]);

        Basket::where('user_id', $user->id)->where('product', $product->code)->update([
            'quantity' => 450,
        ]);

        $this->get(route('basket'))->assertSee('potential_saving&quot;:true');
    }
}
