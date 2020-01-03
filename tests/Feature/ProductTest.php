<?php

namespace Tests\Feature;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check that a customer can see a product on their price list.
     *
     * @test
     */
    public function a_customer_can_see_products_on_their_price_list(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product'       => $product->code,
        ]);

        $this->get($product->path())->assertSee($product->description);
    }

    /**
     * Check a customer cannot see a product not on their price list.
     *
     * @test
     */
    public function a_customer_cannot_see_products_not_on_their_price_list(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => 'ABC123',
            'product'       => $product->code,
        ]);

        $this->get($product->path())->assertDontSee($product->description);
    }
}
